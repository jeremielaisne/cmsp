// ES6 Modules
// --------------------
import '../../app.js';
import MicroModal from 'micromodal';
import iziToast from 'izitoast';

// SASS files
// --------------------
import '../../scss/pages/contenu.scss';
import '../../scss/components/izitoast.scss';
import '../../scss/components/table.scss';

// DOM Elements
// --------------------

class Contenu {

    constructor(options) {

        let defaults = {};

        let _options = {...defaults, ...options};

    }

    init() {

        // Init Modal
        // --------------------
        this.initModal()

        // Fermer une modale
        // --------------------
        this.closeModal()

        // Ajouter un contenu
        // --------------------
        this.addContenu()
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
            debugMode: false
        });
    }

    closeModal() {
        $(".modal__close").on("click", function(){
            MicroModal.close("modal-add");
        })
    }

    addContenu(){
        // Ajout
        $(".modal-open-add").on("click", function(){
            MicroModal.show("modal-add");
        })

        $("form").on("submit", function(e){
            e.preventDefault()
            
            var formData = {
            };
            
            iziToast.question({
                timeout: 10000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "Ajouter",
                message: 'Voulez-vous ajouter cette catégorie ?',
                position: 'center',
                buttons: [
                    ['<button><b>OUI</b></button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        $.ajax({
                            url: "/contenu/add",
                            method: "POST",
                            data: formData,
                            dataType: "JSON",
                            success: function(data){
                            }
                        })
                    }, true],
                    ['<button>NON</button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
    
                    }],
                ]
            });
        })
    }
}

let _Contenu = new Contenu();
_Contenu.init();