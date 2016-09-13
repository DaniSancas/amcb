function onSubmitShowSpinner(id){
    $(id).addClass("active");
    $(id).attr('readonly', 'readonly');
    $(id).html('Guardando...');
    return true;
}
