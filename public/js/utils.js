function divDelete(div)
{
    $(div).fadeOut(250,function() {
        $(this).remove();

    });
}


function debug(string)
{
    console.log(string);
}

function showError(msg)
{
    let div = $('<div class="notification blurred-bg click-to-delete" onclick="divDelete(this);"> <div>')
    .append($('<p></p>').append($('<i class="fas fa-exclamation-circle" style="color:red;"></i>').text(msg)));
    $(div).hide().appendTo("#notification-panel").slideDown(250);
}

function showMessage(msg,type="info")
{
    icon='<i class="fas fa-info-circle"></i>';
    if(type=="delete")
    {
        icon='<i class="far fa-trash-alt"></i>';
    }

    let div= $('<div class="notification blurred-bg click-to-delete" onclick="divDelete(this);"></div>');
    let par= $('<p></p>').text(msg);
    par.prepend(icon);
    div.append(par);

    $(div).hide().appendTo("#notification-panel").slideDown(250);
}