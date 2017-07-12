declare const jQuery: any

jQuery(document).ready(() => {
  jQuery('#course_date').datepicker({
    format: 'dd/mm/yyyy',
    startDate: new Date(),
    autoclose:true,
    daysOfWeekDisabled: [0,6]
  });
})
