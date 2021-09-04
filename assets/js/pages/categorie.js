// ES6 Modules
// --------------------
import '../../app.js';
import MicroModal from 'micromodal';
import iziToast from 'izitoast';

//import 'select2';  
//import 'select2/dist/css/select2.css';

// SASS files
// --------------------
import '../../scss/pages/categorie.scss';
import '../../scss/components/izitoast.scss';
import '../../scss/components/table.scss';

// DOM Elements
// --------------------

class Categorie {

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

        // Ajouter une catégorie
        // --------------------
        this.addCategorie()

        // Editer une catégorie
        // --------------------
        this.editCategorie()

        // Supprimer une catégorie
        // --------------------
        this.deleteCategorie()

        // Changer de site
        // --------------------
        this.changeSite()

        // Init select2
        // --------------------
        //this.initSelect2()
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

    initSelect2() {
        $(document).ready(function() {
            $('.select2-enable').select2({
                placeholder: 'Selectionnez une option'
            });
        })
    }

    changeSite() {
        $("#select_sites").on("change", function(e){

            var formData = {
                site: $(this).val()
            };
            $.ajax({
                url: "/dashboard/categorie/",
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
            iziToast.info({
                timeout: 1000, 
                icon: 'fas fa-check', 
                title: 'OK', 
                message: 'Ajout annulé !'
            });
            setTimeout(function(){location.reload()}, 1000)
        })
    }

    addCategorie(){
        // Ajout
        $(".modal-open-add").on("click", function(){
            MicroModal.show("modal-add");
        })

        $("form").on("submit", function(e){
            e.preventDefault()
            
            var formData = {
                libelle: $("#categorie_libelle").val(),
                description: $("#categorie_description").val(),
                champ: $("#categorie_champs").val(),
                zone: $("#categorie_zone option:selected").val()
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
                            url: "/dashboard/categorie/add",
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
                                } else {
                                    iziToast.warning({
                                        timeout: 1500, 
                                        icon: 'fas fa-check', 
                                        title: 'Attention', 
                                        message: 'La champ "champs" est actuellement vide, ce qui est anormal !'
                                    });
                                    setTimeout(function(){location.reload()}, 1500)
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

    editCategorie(){
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
                .parent()
                .parent()
                .find("textarea")
                .removeClass("border-0")
                .removeAttr("readonly")
            ;
            $(this)
                .parent()
                .parent()
                .find("select")
                .removeClass("select-dropdown")
                .find("option")
                .removeAttr("disabled")
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
                .parent()
                .parent()
                .find("select")
                .addClass("select-dropdown")
                .find("option")
                .attr("disabled")
            ;
            $(this)
                .parent()
                .parent()
                .find("textarea")
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
            var libelle = $(this).parent().parent().find(".edit_categorie_libelle").val()
            var zone = $(this).parent().parent().find(".edit_categorie_zone_page option:selected").data("id")
            var description = $(this).parent().parent().find(".edit_categorie_description").val()

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
                            url: "/dashboard/categorie/edit",
                            data : {"id":id, "libelle":libelle, "zone":zone, "description":description},
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

    deleteCategorie(){
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
                message: 'Confirmer-vous la suppression de la catégorie ?',
                position: 'center',
                buttons: [
                    ['<button><b>OUI</b></button>', function (instance, toast) {
                
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        $.ajax({
                            url: "/dashboard/categorie/delete",
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

let _Categorie = new Categorie();
_Categorie.init();
