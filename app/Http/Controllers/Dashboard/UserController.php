<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\MessageUserMail;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\Handler;
use App\Models\Email;
use FFI\Exception;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::All()->where('is_administrator', false);

        $user_orders = $this->getUsersWithOrders();

        return view('dashboard.users.index', compact('users', 'user_orders'));
    }

    /**
     * Get Users with last Order
     *
     * @return Illuminate\Support\Facades\DB
     */
    public function getUsersWithOrders()
    {
        $users = DB::table('users')
            ->join('orders', function ($join) {
                $join->on('users.id', '=', 'orders.user_id')
                    ->orderBy('id', 'asc')
                    ->limit(1);
            })->where('is_administrator', false)->get(['name', 'email', 'phone', 'transaction_id', 'paid_at', 'total', 'currency']);

        // DB::listen(function($users) {
        //     Log::info($users->sql);
        // });

        return $users;
    }

    /**
     * Downloads users with last order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Strem
     */
    public function dowloadWithOrder(Request $request)
    {
        $user_orders = $this->getUsersWithOrders();

        $list = $user_orders->toArray();

        $ouput = [];

        foreach ($list as $row) {
            $ouput[] = (array) $row;
        }

        $response = $this->makeDownload($ouput);

        return response()->stream($response['callback'], 200, $response['headers']);
    }

    /**
     * Downloads users 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Strem
     */
    public function dowload(Request $request)
    {
        $list = User::where('is_administrator', false)->get(['name', 'email', 'phone'])->makeHidden(['gravatar'])->toArray();

        $response = $this->makeDownload($list);

        return response()->stream($response['callback'], 200, $response['headers']);
    }


    /**
     * Make a file to dowload
     *
     * @return Illuminate\Support\Facades\DB
     */
    public function makeDownload(array $data)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=usuarios.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        # add headers for each column in the CSV download
        array_unshift($data, array_keys($data[0]));

        $callback = function () use ($data) {
            $FH = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return array('callback' => $callback, 'headers' => $headers);
    }

    /**
     * Send Emails To Users
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function sendEmail(Request $request)
    {
        Log::info($request);

        $messages = array(
            'usersIds.required' => 'Necesita seleccionar usuarios',
        );

        $validator = Validator::make($request->all(), [
            'message' => ['required', 'string', 'max:500'],
            'subject' => ['required', 'string', 'max:100'],
            'upload_file' => 'nullable',
            'backgroud_color' => 'nullable',
            'usersIds' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $usersIds = json_decode($request['usersIds']);

        $email = Email::create([
            'subject' => $request['subject'],
            'message' => $request['message'],
            'users_ids' => $usersIds,
            'background_color' => $request['background_color']
        ]);

        if($request->file('upload_file'))
        {
            $email->image()->create([
                'url' => $request->file('upload_file')->store(config('app.env') . '/emails', 's3'),
            ]);  
        } 

        foreach ($usersIds as $key => $value) {

            $user = User::find($value);

            try {

                Mail::to($user->email)->send(new MessageUserMail($email, $user));

            } catch (Exception $ex) {

                Log::error($ex->getMessage());

                $data = [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Hubo un error, contacte con el administrador de la página'
                ];

                return response()->json($data);
            }
        }

        return response()->json(['success' => 'emails enviados.']);
    }
}
