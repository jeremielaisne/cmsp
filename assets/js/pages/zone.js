// ES6 Modules
// --------------------
import '../../app.js';
import MicroModal from 'micromodal';
import iziToast from 'izitoast';

// SASS files
// --------------------
import '../../scss/pages/zone.scss';
import '../../scss/components/izitoast.scss';
import '../../scss/components/table.scss';

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

        // Ajouter une zone
        // --------------------
        //this.addZone()
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

    addZone(){
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: "Ajouter",
            message: 'Nouvelle zone ?',
            position: 'center',
            buttons: [
                ['<button><b>OUI</b></button>', function (instance, toast) {
            
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    $("form").trigger("submit");

                }, true],
                ['<button>NON</button>', function (instance, toast) {
            
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
            onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    }
}

let _Zone = new Zone();
_Zone.init();
