@extends('layouts.landing.app')

@section('title', __('Acerca de'))

@section('breadcrumb')
<section class="breadcrumb-area bg-img bg-overlay" style="background-image: url({{ asset('images/secciones-banners.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ __('Acerca de') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    <i class="icon_house_alt"></i> {{ __('Tienda') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('Acerca de') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- About Us Area Start -->
<div class="about-us-area section-padding-80-0 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="about-us-content mb-80">
                    <h3 class="wow fadeInUp" data-wow-delay="100ms">
                        {{ __('¿QUIEN SOY?') }}
                    </h3>
                    <div class="line wow fadeInUp" data-wow-delay="200ms"></div>

                    <p class="wow fadeInUp" data-wow-delay="300ms">
                        {{
                            __('HOLA,
                                Mi nombre es Paola Raya
                                Soy educadora de profesión, por azares de la vida abandone mi profesión y ahora me encuentro emprendiendo mi propio negocio: Lady Records
                                Desde mis inicios me encantaba la música, bailar y cantar (aun que no canto nada bien) por eso cuándo se presento la oportunidad de entrar en este fantástico mundo de los Dee Jay ́s no lo pensé dos veces y me sumergí en este mundo relacionado con la música.
                                Fue entonces que empece a notar sus dificultades relacionadas con las descargas y por eso es que ahora estoy aquí, dispuesta a ayudarte a mejorar esa parte laboral que a nadie le gusta hacer...
                                Me gusta despertar cada mañana sabiendo que doy lo mejor de mí, llenando cada DD (disco duro) con todo el cariño y profesionalismo que mereces y así al igual que yo puedas ofrecer lo mejor de TI en los eventos.
                                Gracias por brindarme tu confianza y apoyo.')
                        }}
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-us-content mb-80">
                    <h3 class="wow fadeInUp" data-wow-delay="100ms">
                        {{ __('OBJETIVO') }}
                    </h3>
                    <div class="line wow fadeInUp" data-wow-delay="200ms"></div>

                    <p class="wow fadeInUp" data-wow-delay="300ms">
                        {{
                            __('Mi propósito es tu comodidad, me comprometo a brindarte la mejor experiencia mandando tu Disco Duro listo para usarse....
                                “En Lady Records lo mas valioso es tu tiempo”
                                ...no te compliques descargando ...no inviertas tu tiempo en acomodar
                                Déjame estos pequeños detalles a mí, yo me aseguro de descargar y acomodar lo mejor en la calidad que necesitas.')
                        }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="about-us-content mb-80">
                    <h3 class="wow fadeInUp" data-wow-delay="100ms">
                        {{ __('¿QUE TE OFRECE LADY RECORDS?') }}
                    </h3>
                    <div class="line wow fadeInUp" data-wow-delay="200ms"></div>

                    <p class="wow fadeInUp" data-wow-delay="300ms">
                        {{
                            __('Cada disco duro es llenado con un amplio cuidado y revisión minuciosa para que el contenido no este repetido, es libre de sellos, logos, comerciales y publicidad.
                                Están en completo orden por genero y contamos con gran variedad en los genero que más te gustan.
                                Sabemos lo importante que son para ti estos aspectos, es por eso que pongo todo mi empeño y dedicación en ofrecerte lo que te mereces.')
                        }}
                    </p>
                    <br>
                    <ul class="mb-4" style="line-height: 2rem;">
                        <li>{{ __('-disco duro') }}</li>
                        <li>{{ __('-contenido') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Us Area End -->
@endsection