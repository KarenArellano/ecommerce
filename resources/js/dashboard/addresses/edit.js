
$("input.check_same_address").click(function()
{
    toogle($(this), this.checked)
})

$("input.check_same_address").ready(function()
{
    toogle($(this), true)
})

function toogle(element, isSameAdress)
{
    console.log(element, "Element check ")

    element.val(isSameAdress) 
    
    this.checked = isSameAdress

    $('.container_address  input.form-control').prop('disabled', isSameAdress) 

    $('.container_address select.form-control').prop('disabled', isSameAdress) 
}