$(function(){  

      // Evento click
      $('#btnAgregar').on('click', function(e) {
          // Prevenir la acción por defecto
          e.preventDefault();
          // Se lanza el método bPopup 
          $('#frame').bPopup({
            contentContainer:'.content',
          }
          );
      });

});