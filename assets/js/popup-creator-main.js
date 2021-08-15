;(function($){
    $(document).ready(function(){
        PlainModal.closeByEscKey = false;
        PlainModal.closeByOverlay = false;
        var modal = new PlainModal(document.getElementById('modal-content'));
        modal.closeButton = document.getElementById('close-button');
        modal.open();
    });
})(jQuery)