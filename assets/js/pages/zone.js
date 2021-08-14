// ES6 Modules
// --------------------
import '../../app.js';
import MicroModal from 'micromodal';

// SASS files
// --------------------
import '../../scss/pages/zone.scss';

// DOM Elements
// --------------------

class Zone {

    constructor(options) {

        let defaults = {};

        let _options = {...defaults, ...options};

    }

    init() {

        // Init Modal
        // --------------------
        this.initModal()

    }

    initModal() {
        MicroModal.init({
            onShow: modal => console.info(`${modal.id} is shown`),
            onClose: modal => console.info(`${modal.id} is hidden`),
            openTrigger: 'data-custom-open',
            closeTrigger: 'data-custom-close',
            openClass: 'is-open',
            disableScroll: true,
            disableFocus: false,
            awaitOpenAnimation: false,
            awaitCloseAnimation: false,
            debugMode: true
        });
    }

    showModal(id) {
        MicroModal.show(id);
    }

    closeModal(id) {
        MicroModal.close(id);
    }
}

let _Zone = new Zone();
_Zone.init();
