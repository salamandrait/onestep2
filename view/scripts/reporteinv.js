var tiporeporte;
var optipo;

function init() {

   SelectItem();
   SelectChange();


   $("#btnDesde,#btnHasta").click(function () {
      $("select.cl").
         val("")
      niceSelect("update");
   });
}

function SelectChange() {

   $("#tiporeporte")
      .click(function () {

         $("form.tabla").addClass('hidden');
         $("form.art").addClass('hidden');

         $('#rtablas,#rarticulos,#roperacion,#rmovimiento,#ranalisis')
            .val("")
            .niceSelect('update');
      })
      .change(function () {

         tiporeporte = $(this).val();

         if (tiporeporte == 'tablas') {
            $("#rtablas").removeClass('hidden');

            $("#roperacion,#rarticulos,#rmovimiento,#ranalisis").addClass('hidden');

         } else if (tiporeporte == 'rarticulos') {
            $("#rarticulos").removeClass('hidden');
            $("#rtablas,#roperacion,#rmovimiento,#ranalisis").addClass('hidden');

         } else if (tiporeporte == 'opinventario') {
            $("#roperacion").removeClass('hidden');
            $("#rtablas,#rarticulos,#rmovimiento,#ranalisis").addClass('hidden');

         } else if (tiporeporte == 'movinventario') {
            $("#rmovimiento").removeClass('hidden');
            $("#rtablas,#rarticulos,#roperacion,#ranalisis").addClass('hidden');

         } else if (tiporeporte == 'analisis') {
            $("#ranalisis").removeClass('hidden');
            $("#rtablas,#rarticulos,#roperacion,#rmovimiento").addClass('hidden');
         }
      });

   $('#rtablas,#rarticulos,#rmovimiento')
      .val("")
      .change(function () {

         $('<option value="" class="hidden"></option>').appendTo("select.cl");
         $("select.cl")
            .val("")
            .niceSelect('update');

         var valor = $(this).val();

         if (valor == 'tbarticulo') {

            $("#tbform1").removeClass('hidden');
            $("#tbform2,#tbform3,#tbform4,#tbform5").addClass('hidden');
         }
         else if (valor == 'tbcategoria') {

            $("#tbform2").removeClass('hidden');
            $("#tbform1,#tbform3,#tbform4,#tbform5").addClass('hidden');
      
         }
         else if (valor == 'tblinea') {

            $("#tbform3").removeClass('hidden');
            $("#tbform1,#tbform2,#tbform4,#tbform5").addClass('hidden');
         }
         else if (valor == 'tbunidad') {

            $("#tbform4").removeClass('hidden');
            $("#tbform1,#tbform2,#tbform3,#tbform5").addClass('hidden');
         }
         else if (valor == 'tbdeposito') {
            $("#tbform5").removeClass('hidden');
            $("#tbform1,#tbform2,#tbform3,#tbform4").addClass('hidden');
         } 

         else if (valor == 'artstock') {
            $("#artform1").removeClass('hidden');
            $("#artform2,#artform3,#artform4,#artform5,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'artstockdep') {
            $("#artform2").removeClass('hidden');
            $("#artform1,#artform3,#artform4,#artform5,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'artstockund') {
            $("#artform3").removeClass('hidden');
            $("#artform1,#artform2,#artform4,#artform5,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'artcosto') {
            $("#artform4").removeClass('hidden');
            $("#artform1,#artform2,#artform3,#artform5,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'artprecio') {
            $("#artform4").removeClass('hidden');
            $("#artform1,#artform2,#artform3,#artform5,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'artcostoprecio') {
            $("#artform5").removeClass('hidden');
            $("#artform1,#artform2,#artform3,#artform4,#artform6,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'valoract') {
            $("#artform6").removeClass('hidden');
            $("#artform1,#artform2,#artform3,#artform4,#artform5,#artform7").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'valordep') {
            $("#artform7").removeClass('hidden');
            $("#artform1,#artform2,#artform3,#artform4,#artform5,#artform6").addClass('hidden');
            $("form.tabla").addClass('hidden');
         }
         else if (valor == 'movarticulo') {
            $("#movform1").removeClass('hidden');
            $("#movform2").addClass('hidden');
            $("form.tabla").addClass('hidden')
         }
         else if (valor == 'movfecha') {
            $("#movform2").removeClass('hidden');
            $("#movform1").addClass('hidden');
            $("form.tabla").addClass('hidden')
         }

      });
}

function SelectItem() {

   $.post('../ajax/reporteinv.php?op=Articulo&tipo=' + 'cod', function (d) {
      $("#codarticuloa,#codarticulob")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Articulo&tipo=' + 'desc', function (d) {
      $("#descarticuloa,#descarticulob")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Articulo&tipo=' + 'ref', function (d) {
      $("#refa,#refb")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Articulo&tipo=' + '', function (d) {
      $("#articuloa,#articulob")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Categoria&tipo=' + 'cod', function (d) {
      $("#codcategoriaa,#codcategoriab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Categoria&tipo=' + 'desc', function (d) {
      $("#desccategoriaa,#desccategoriab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Categoria&tipo=' + 'art', function (d) {
      $("#categoriaa,#categoriab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Linea&tipo=' + 'cod', function (d) {
      $("#codlineaa,#codlineab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Linea&tipo=' + 'desc', function (d) {
      $("#desclineaa,#desclineab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Linea&tipo=' + 'art', function (d) {
      $("#lineaa,#lineab")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Unidad&tipo=' + 'cod', function (d) {
      $("#codunidada,#codunidadb")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Unidad&tipo=' + 'desc', function (d) {
      $("#descunidada,#descunidadb")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Unidad&tipo=' + 'art', function (d) {
      $("#unidada,#unidadb")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Deposito&tipo=' + 'cod', function (d) {
      $("#coddepositoa,#coddepositob")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Deposito&tipo=' + 'desc', function (d) {
      $("#descdepositoa,#descdepositob")
         .html(d)
         .niceSelect('update');
   });

   $.post('../ajax/reporteinv.php?op=Deposito&tipo=' + 'art', function (d) {
      $("#depositoa,#depositob")
         .html(d)
         .niceSelect('update');
   });

}

$(function () {

   $("#tiporeporte").val("");

   //desabilitar Tecla Intro al enviar formularios
   $("#formulario").keypress(function (e) {
      if (e.which == 13) {
         return false;
      }
   });

   $(".ffecha").datepicker({
      changeMonth: true,
      changeYear: true,
      autoclose: "true",
      format: "yyyy-mm-dd",
      todayBtn: true,
   }).datepicker("setDate", new Date());

});

init();