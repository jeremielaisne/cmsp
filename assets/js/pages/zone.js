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

        // Fermer une modale
        // --------------------
        this.closeModal()

        // Ajouter une zone
        // --------------------
        this.addZone()

        // Modifier une zone
        // --------------------
        this.editZone()

        // Supprimer une zone
        // --------------------
        this.deleteZone()
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

    addZone(){
        // Ajout
        $(".modal-open-add").on("click", function(){
            MicroModal.show("modal-add");
        })

        $("form").on("submit", function(e){
            e.preventDefault()
            
            var formData = {
                page: $("#zone_page").val(),
                libelle: $("#zone_libelle").val(),
                url: $("#zone_url").val()
            };
            
            iziToast.question({
                timeout: 10000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "Ajouter",
                message: 'Voulez-vous ajouter cette zone ?',
                position: 'center',
                buttons: [
                    ['<button><b>OUI</b></button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        $.ajax({
                            url: "/zone/add",
                            method: "POST",
                            data: formData,
                            dataType: "JSON",
                            success: function(data){
                                if(data == true){
                                    iziToast.success({
                                        timeout: 1000, 
                                        icon: 'fas fa-check', 
                                        title: 'OK', 
                                        message: 'L\'ajout a bien été effectuée !'
                                    });
                                    setTimeout(function(){parent.location.reload()}, 1000)
                                }
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

    editZone(){
        // Modification
        $(".btn-edit").on("click", function(){
            $(this)
                .parent()
                .parent()
                .find("input")
                .removeClass("border-0")
                .removeAttr("readonly")
            ;
            $(this)
                .addClass("d-none")
                .next()
                .removeClass("d-none")
                .next()
                .removeClass("d-none")
                .next()
                .removeClass("d-none")
                .next()
                .addClass("d-none")
            ;
        })

        $(".btn-edit-annule").on("click", function(){
            $(this)
                .parent()
                .parent()
                .find("input")
                .addClass("border-0")
                .attr("readonly")
            ;
            $(this)
                .addClass("d-none")
                .next()
                .addClass("d-none")
                .next()
                .removeClass("d-none")
                .prev()
                .prev()
                .prev()
                .addClass("d-none")
                .prev()
                .removeClass("d-none")
                .prev()
                .removeClass("d-none")
            ;
        })

        $(".btn-edit-confirm").on("click", function(){
            
            var id = $(this).data("id")
            var libelle = $(this).parent().parent().find(".edit_zone_libelle").val()
            var page = $(this).parent().parent().find(".edit_zone_page").val()
            var url = $(this).parent().parent().find(".edit_zone_url").val()

            iziToast.question({
                timeout: 10000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "Modification",
                message: 'Voulez-vous modifier cette zone ?',
                position: 'center',
                buttons: [
                    ['<button><b>OUI</b></button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        $.ajax({
                            url: "/zone/edit",
                            data : {"id":id, "libelle":libelle, "page":page, "url":url},
                            method: "POST",
                            dataType: "JSON",
                            success: function(data){
                                if(data == true){
                                    iziToast.success({
                                        timeout: 1000, 
                                        icon: 'fas fa-check', 
                                        title: 'OK', 
                                        message: 'La modification a bien été effectuée !'
                                    });
                                    setTimeout(function(){location.reload()}, 1000)
                                }
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

    deleteZone(){
        // Suppression
        $(".btn-delete").on("click", function(){
            var button = $(this)
            var id = $(this).data("id")
            iziToast.question({
                timeout: 10000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: "Supprimer",
                message: 'Confirmer-vous la suppression de la zone ?',
                position: 'center',
                buttons: [
                    ['<button><b>OUI</b></button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        $.ajax({
                            url: "/zone/delete",
                            data : { "id": id },
                            method: "POST",
                            dataType: "JSON",
                            success: function(data){
                                if(data == true){
                                    $(button).parent().html("<span class='text-success fs-9'>Element supprimé !</span>")

                                    iziToast.success({
                                        timeout: 1000, 
                                        icon: 'fas fa-check', 
                                        title: 'OK', 
                                        message: 'La suppression a bien été effectuée !'
                                    });
                                    setTimeout(function(){location.reload()}, 1000)
                                }
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

let _Zone = new Zone();
_Zone.init();
