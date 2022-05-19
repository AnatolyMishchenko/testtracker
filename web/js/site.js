$(document).ready(function () {
   $('.tasks-list tr td .check-task').click(function() {
      let idTask = '';
      $('.tasks-list tr td .check-task').each(function() {
         if ($(this).is(':checked')) {
            let id = $(this).val();
            idTask += ','+id;
         }
      });
      if (idTask.length > 0) {
         idTask = idTask.slice(1);
         $('#dynamicmodel-arrtasks').val(idTask);
         $('.filter-mass').show();
      } else {
         $('.filter-mass').hide();
      }
   });
});