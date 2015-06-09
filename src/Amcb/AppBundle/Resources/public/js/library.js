function onSubmitShowSpinner(id){
    $(id).addClass("active");
    $(id).attr('readonly', 'readonly');
    $(id).html('Guardando...');
    return true;
}

function filtrarFicheros(filtro)
{
    var filtroIndex = $(filtro).val();
    var oldLocation = location.href;
    var cleanLocation = oldLocation.substr(0, oldLocation.indexOf('?'));

    if(filtroIndex != 0)
    {
        location.href = cleanLocation + '?filtro=' + filtroIndex;
    }else{
        location.href = cleanLocation;
    }
}
