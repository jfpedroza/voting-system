/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
    Author     : KEVIN
*/
function mostrar(){
    document.getElementById('divCargando').style.display = 'block';
}

$("#btn-buscar").click(function(){
    switch(pagina){
        case 1:
            buscarUsuarios();
            break;
        case 2:
            buscarUsuariosporMesa();
            break;
    }
});


$("#buscar").keyup(function(e){
    if (e.keyCode == 13) {
        switch(pagina){
            case 1: 
                buscarUsuarios();
                break;
            case 2:
                buscarUsuariosporMesa();
                break;
        }
    }
});

function buscarUsuarios() {
    var buscar = $("#buscar").val();
    if (buscar !== "") {
        $.ajax({
            url: "../action/buscarCod.php",
            method: "GET",
           data: {
               buscar: buscar
           },
       }).done(function(response){
           $("#tabla-usuarios tbody").empty();
           for (var i=0; i<response.usuario.length; i++){
                var usuario = response.usuario[i];

                var row = "<tr class='font'>"+
                    "<td><center><a href=''><img class='img-circle' src='../img/"+usuario.fotografia+"' width='40px' height='40px'></a></center></td>"+
                    "<td>"+usuario.identificacion+"</td>"+
                    "<td>"+usuario.codigo+"</td>"+
                    "<td>"+usuario.nombres+"</td>"+
                    "<td>"+usuario.apellidos+"</td>"+
                    "<td>"+usuario.email+"</td>"+
                    "<td>"+usuario.rol+"</td>"+
                    "<td>"+usuario.programa+"</td>"+
                 "</tr>";

                 $(row).appendTo("#tabla-usuarios tbody");
                console.log(response);
            }
       });
    }
}

function buscarUsuariosporMesa() {
    var buscar = $("#buscar").val();
    if (buscar !== "") {
        $.ajax({
            url: "../action/buscarUsuariosporMesa.php",
            method: "GET",
           data: {
               buscar: buscar
           },
       }).done(function(response){
           $("#tabla-usuarios tbody").empty();
           var usuario = response.usuario;
           
           var row = "<tr class='font'>"+
                "<td>"+usuario.identificacion+"</td>"+
                "<td>"+usuario.codigo+"</td>"+
                "<td>"+usuario.nombres+"</td>"+
                "<td>"+usuario.apellidos+"</td>"+
                "<td>"+usuario.email+"</td>"+
                "<td>"+usuario.rol+"</td>"+
                "<td>"+usuario.programa+"</td>"+
                "<td>"+usuario.mesa+"</td>"+
                "<td>"+usuario.jornada+"</td>"+
            "</tr>";
    
            $(row).appendTo("#tabla-usuarios tbody");
           console.log(response);
       });
    }else{
        
    }
}