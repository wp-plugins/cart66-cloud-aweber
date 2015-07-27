jQuery( document ).ready(function( $ ) {

  setTimeout( showModal, parseInt(caModalInfo.delay) );

  function showModal() {
    if ( Cookies.get('caShownModal') != 1 ) {
      $('#cc-receipt-notification-modal').modal();
      $('#simplemodal-container').css('height', 'auto');
      $('#simplemodal-container').css('width', 'auto');
      $('#simplemodal-container').css('min-width', parseInt(caModalInfo.width) );
      Cookies.set('caShownModal', 1, { expires: 30 });
    }
  }

});

