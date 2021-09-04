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

        // Changer de site
        // --------------------
        this.changeSite()
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

    changeSite() {
        $("#select_sites").on("change", function(e){

            var formData = {
                site: $(this).val()
            };
            $.ajax({
                url: "/dashboard/contenu/",
                method: "POST",
                data: formData,
                dataType: "JSON",
                success: function(data){
                    if (data == true) {
                        iziToast.info({
                            timeout: 500, 
                            icon: 'fas fa-check', 
                            title: 'OK', 
                            message: 'Changement de site !'
                        });
                        setTimeout(function(){location.reload()}, 500)
                    }
                }
            })
        })
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

    }
}

let _Contenu = new Contenu();
_Contenu.init();