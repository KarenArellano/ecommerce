import bsCustomFileInput from 'bs-custom-file-input';

bsCustomFileInput.init();

// disable the boostrap modal backdrop and keyboard exit
$.fn.modal.prototype.constructor.Constructor.Default.backdrop = 'static';
$.fn.modal.prototype.constructor.Constructor.Default.keyboard = false;