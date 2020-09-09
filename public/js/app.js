
    var upload_id=0;
    var api_url='/api';

    var Session = {logged:false,token:""};


    function main()
    {
        if(localStorage.getItem("token") ===null)
        {
            $(".app-login").show();
        }
        else
        {
            Session.logged=true;
            Session.token=localStorage.getItem("token");
            axios.defaults.headers.common = {'Authorization': `Bearer ${Session.token}`}
            $(".app-root").show(250);
            refreshFiles();
        }
    }

    function showMenu(e)
    {
        var top = e.pageY ;
        var left = e.pageX;
        //debug(e.currentTarget);
        //debug(this);
        $("#context-menu").css("top",top);
        $("#context-menu").css("left",left);
        $("#context-menu").attr("data-file-id",$(this).data("file-id"));
        $("#context-menu").slideDown(200);
        return false;
    }

    $("#context-menu > #delete").on("click", event => {
        file_id = $("#context-menu").attr("data-file-id");
        debug(file_id);
        $("#context-menu").slideUp(300);
        deleteFile(file_id);
    });


    function deleteFile(file_id)
    {
        axios.delete(api_url+"/files/"+file_id).then(resp => {
            divDelete('.file[data-file-id="'+file_id+'"]');
            showMessage("El archivo "+resp.data.filename+" fue eliminado.","delete");
        }).catch( error =>{
            showError(error.response.data.message);
        });
    }

   
    $("html").on("dragover", function(event) {
        event.preventDefault();  
        event.stopPropagation();
        $(this).addClass('dragging');
    });

    $("html").on("dragleave", function(event) {
        event.preventDefault();  
        event.stopPropagation();
        $(this).removeClass('dragging');
    });

    $("html").on("drop", function(event) {
        event.preventDefault();  
        event.stopPropagation();
        var e=event.originalEvent;
        if (e.dataTransfer.items) {
            for (var i = 0; i < e.dataTransfer.items.length; i++) {

                if (e.dataTransfer.items[i].kind === 'file') {
                    var file = e.dataTransfer.items[i].getAsFile();
                    debug(file);
                    uploadFile(file);
                }
            }
        }
    });

    function uploadProgressEvent(percent,id)
    {
        $('.notification[data-upload-id="'+id+'"] > .progress > .progress-bar').css("width",percent+"%");
    }


    function uploadFile(file)
    {
        upload_id++;
        let c_id=upload_id;
        let formData = new FormData();
        const config = {
            onUploadProgress: function(progressEvent) {
                var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                uploadProgressEvent(percentCompleted,c_id);
            }
        }
        formData.append('file', file);
        formData.append('token',Session.token);


        let div = $('<div class="notification blurred-bg"></div>').attr("data-upload-id",c_id);
        let par = $('<p></p>').text('Subiendo archivo: '+file.name);
        par.prepend('<i class="fas fa-cloud-upload-alt"></i>');
        par.append('<span class="badge badge-danger">Cancelar</span>');
        div.append(par);
        div.append('<div class="progress"><div class="progress-bar bg-success  progress-bar-animated" role="progressbar" style="width: 0%" ></div></div>');

        //$("#notification-panel").append(div).slideDown(300);
        $(div).hide().appendTo($("#notification-panel")).slideDown(250);
        axios.post(api_url+"/files/",formData,config).then(resp => {
            $('.notification[data-upload-id="'+c_id+'"]').fadeOut(400);

            var file = new File(resp.data.file);
            $(file.toDiv()).hide().appendTo("#files").fadeIn(2000);
            $('*[data-file-id="'+file.id+'"]').bind("contextmenu",showMenu);

        }).catch(error => {
            showError(error.response.data.message);
            $('.notification[data-upload-id="'+c_id+'"]').fadeOut(400);
        });
    }

    $(document).click(function(event) { 
        $target = $(event.target);
        
        if(!$target.closest('.file').length)
        {
            $(".file").removeClass("selected");

            edit=$('.file[data-editing="1"]');
            
            if(edit.length>0)
            {
                edit.attr("data-editing","0");
                str=edit.children("input").val();
                if(str.length>0)
                {
                    edit.children("input").remove();
                    edit.children("p").text(str)
                    edit.children("p").show();
                }
                else
                {
                    edit.children("input").remove();
                    edit.children("p").show();
                }
            }
        }
        if(!$target.closest('#context-menu').length && 
        $('#context-menu').is(":visible")) {
            $('#context-menu').fadeOut(200);
        }        
    });



    

    function loginClick()
    {
        var user= $("#userForm").val();
        var pass = $("#passForm").val();
        $("#login-form").hide();
        login(user,pass).then( r =>{
            if(r)
            {
                $(".app-login").hide(250, () => {
                    $(".app-root").show(250);
                });
            }
            $("#login-form").show();
        });
    }


    


    async function login(user,pass){

        if(Session.logged)
        {
            return false;
        }

        params = {
            email: user,
            password:pass
        }
        try
        {
            resp = await axios.post(api_url+'/auth/login',params);
            Session.token = resp.data.access_token;
            Session.logged=true;
            localStorage.setItem("token", Session.token);
            axios.defaults.headers.common = {'Authorization': `Bearer ${Session.token}`}
            return true;
        }
        catch(error)
        {
            showError(error.response.data.message);
            Session.logged=false;
            return false;
        }
    }

    function refreshFiles(){
        $("#files").empty();
        $("#files").hide();
        $("#files-loader").show();
        axios.get(api_url+'/files').then(resp => {
            
            resp.data.forEach( i => {
                
                //debug(i);
                var nfile = new File(i);
                //showMessage(nfile.name);
                //debug(nfile);
                
                $("#files").append(nfile.toDiv());
                $('*[data-file-id="'+nfile.id+'"]').bind("contextmenu",showMenu);   
            });
            $("#files").fadeIn(300);
            $("#files-loader").hide();
        }).catch(error => {
            showError(error.response.data.message);
        })
    }

    function openFile(id)
    {
        var win = window.open($('.file[data-file-id="'+id+'"]').data("file-url")+"?token="+Session.token, '_blank');
        win.focus();
    }
    

    function fileSelector()
    {
        $('#file-upload').click();
    }

    $("#file-upload").change(function(){
        var val=$("#file-upload").val();
        if(val.length>0)
        {
            
            var file=$('#file-upload').prop('files')[0];
            uploadFile(file);
            
            
        }
        $("#file-upload").val("");
    });


    async function loadPreviews()
    {
        var files = [];
        $(".file").each(function() {
            files.push(this);
        });
        for (i = 0, len = files.length; i < len; i++) {
            f_id = $(files[i]).attr("data-file-id");
            f_mime=$(files[i]).attr("data-file-mime");
            f = new File({id:f_id,mime:f_mime});
            r=await f.getPreview();
            if(r==1) await sleep(150);
        }
        return 1;
    }

    

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function editName(elem)
    {
        const text=$(elem).text();
        setTimeout(function(){
        $(elem).parent().attr("data-editing","1");
        $(elem).parent().append($('<input class="thin-box" >').text(text));
        $(elem).hide();
        },10);
    }


    function selectFile(file)
    {
        $(".file").removeClass("selected");
        setTimeout(function() {
            $(file).addClass("selected");
        },10);
    }




main();

    

    


    


