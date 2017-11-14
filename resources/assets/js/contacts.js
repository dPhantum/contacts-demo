$(document).ready(function(){

// --------------------------------------------------------
// Create contact class with crud operational methods
// --------------------------------------------------------
window.Contact = {

    _MaxCustomFields : 5,
    _RemainingFields : 5,
    _id : 0,
    _name : '',
    _email : '',
    _phone : '',
    _option_1 : '',
    _option_2 : '',
    _option_3 : '',
    _option_4 : '',
    _option_5 : '',

    /* Getters/Setters for Data Injection Binding to screen elements */
    get id() { return this._name; },
    set id(value) { this._id = value; this.inject('id', value); },
    get name() { return this._name; },
    set name(value) { this._name = value; this.inject('name', value); },
    get email(){ return this._email; },
    set email(value){ this._email = value; this.inject('email', value); },
    get phone() { return this._phone; },
    set phone(value) { this._phone = value; this.inject('phone', value); },
    get option_1() { return this._option_1; },
    set option_1(value) { this._option_1 = value; this.inject('option_1', value); },
    get option_2() { return this._option_2; },
    set option_2(value) { this._option_2 = value; this.inject('option_2', value); },
    get option_3() { return this._option_3; },
    set option_3(value) { this._option_3 = value; this.inject('option_3', value); },
    get option_4() { return this._option_4; },
    set option_4(value) { this._option_4 = value; this.inject('option_4', value); },
    get option_5() { return this._option_5; },
    set option_5(value) { this._option_5 = value; this.inject('option_5', value); },

    inject : function(field, value){
        $("tr[data-id=" + this._id + "]").find("td.data-" + field).html(value);
    },

    showModal : function(){
        $("#contactEditor").modal('show');
        return false;
    },
    create : function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('form input[name="_token"]').val()
            }
        });
        var formData = $("form.contact-form").serialize();
        console.log(formData);

        $.ajax({
            type: 'POST',
            url: '/contact',
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var cClone = $('tr.contact-clonee').clone();

                this._id =data.id;
                cClone.attr('data-id',data.id);
                $(".contact-form input#id").val(data.id);
                cClone.attr('data-row-id',($('tr.data-row').length+1));
                cClone.find('.btn').each(function(){ $(this).attr('data-id',data.id); });
                cClone.removeClass('hidden').removeClass('contact-clonee').addClass('data-row');
                console.log(cClone);

                $('.data-table-elements tr:last').after(cClone);
                
                $(".empty-set").addClass('hidden');

                // Read form into object, and implicit injection in to table
                Contact.injectFormToObject();
            },
            error: function (data) {
                console.log(data);
                var msg;
                if (data.errors){
                    msg = "<br><ul>";
                    $.each(data.errors, function(key,value) {
                        msg = msg + ' <li> '+ key + ': '+ value[0] + '</li>';
                    });
                    msg = msg + '</ul>';
                };
                Contact.showAlert('Oops! ' + data.message, '<i class="fa fa-exclemation"></i>', 'red',false)
                console.log('Error:', data);
            }
        });

        $("#contactEditor").modal('hide');

        return false;
    },

    read : function (id) {

        // ----------------------------------
        // Populate the object by the iid
        // ----------------------------------
        this.injectTableToObject(id);

        // ----------------------------------
        // Clear form of any previous entries
        // ----------------------------------
        this.resetForm();
        this._RemainingFields = 5;

        // --------------------------------------
        // Inject the current data we are reading
        // --------------------------------------
        this.injectObjectToForm();

        // ---------------------------------------------
        // Rest the counter display in the modal dialog
        // ---------------------------------------------
        if (this._option_1 != '') {
            this._RemainingFields--;
            $(".remaining-fields").html(this._RemainingFields)
        }

        if (this._option_2 != '') {
            $('.contact-form').find('.optional-2-container').removeClass("hidden");
            this._RemainingFields--;
        }
        else {
            $('.contact-form').find('.optional-2-container').addClass("hidden");
        }
        if (this._option_3 != '') {
            $('.contact-form').find('.optional-3-container').removeClass("hidden");
            this._RemainingFields--;
        }
        else {
            $('.contact-form').find('.optional-3-container').addClass("hidden");
        }
        if (this._option_4 != '') {
            $('.contact-form').find('.optional-4-container').removeClass("hidden");
            this._RemainingFields--;
        }
        else {
            $('.contact-form').find('.optional-4-container').addClass("hidden");
        }
        if (this._option_5 != '') {
            this._RemainingFields--;
            $('.contact-form').find('.optional-5-container').removeClass("hidden");
        }
        else {
            $('.contact-form').find('.optional-5-container').addClass("hidden");
        }

        // --------------------------------------------------------
        // If slots are taken then disable the ability to add more
        // --------------------------------------------------------
        if (this._RemainingFields == 0) {
            $(".add-opt-btn").attr('disabled',true);
        }
        $('body').find('.remaining-fields').html(this._RemainingFields);
        $("#contactEditor").modal('show');
        return false;
    },
    // -----------------------------
    // Save the edit dialog values
    // -----------------------------
    update : function (id) {

        if (id==0 || id===undefined) {
            this._id="";
            this.create();
            return;
        }

        // Read form into object
        this.injectFormToObject();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('form input[name="_token"]').val()
            }
        });
        var formData = $("form.contact-form").serialize();

        $.ajax({
            type: 'PATCH',
            url: '/contact/'+id,
            data: formData,
            dataType: 'json',
            success: function (data) {
                Contact.showAlert('Update complete for ' + Contact.name, '<i class="fa fa-info-circle"></i>');
            },
            error: function (data) {
                Contact.showAlert('Oops! Could not create the record','<i class="fa fa-exclemation"></i>','red',false)
                console.log('Error:', data);
            }
        });


        // if all passes then close the modal
        // data injection has already sync'd the form and display

        $("#contactEditor").modal('hide');

        return;
    },

    delete : function (id) {
        this.injectTableToObject(id);

        this.showAlert(
            'Are you sure you want to delete ' + this._name
            + '? <i class="btn btn-danger"  onclick="Contact.doDelete(' + id + ');"> YES, delete it! </i> ' +
            '   <i class="btn btn-primary" onclick="Contact.hideAlert()">NO, wait! I changed my mind.</i> ',
            ' <i class="fa fa-warning fa-2x"></i>',
            'red', true
        );
        return;
    },

    doDelete : function (id) {
        this.hideAlert();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('form input[name="_token"]').val()
            }
        });
        $.ajax({

            type: "DELETE",
            url: '/contact/' + id,
            success: function (data) {
                console.log(data);

                dataRow = $(".data-table-elements").find("tr[data-id=" + id + "]");
                $(dataRow).remove();
                Contact.showAlert(
                    Contact.name + ' has been deleted. ',
                    ' <i class="fa fa-info-circle fa-2x"></i>'
                );
                Contact.resetForm();
            },
            error: function (data) {
                console.log('Error:'+ data.statusText);
            }
        });
        return;
    },

    addOption : function(Option){
        var optionList = [];
        var x = 0;

        // Save the list, all but the deleted record
        $('.opt-field').each(function(key, optRecord){
            if ($(optRecord).attr('data-option') == Option) {
                optionList[x++] = $(optRecord).val();
                optionList[x++] = '';
            }
            else if ($(optRecord).val() != ''){
                optionList[x++] = $(optRecord).val();
            }
        });

        var x = optionList.length;
        Contact._RemainingFields = Contact._MaxCustomFields;

        // Re-assign the form values without the deleted element
        $('.opt-field').each(function(key, optRecord){
            if (key < x){
                $(".contact-form").find("input#option_" + (key+1)).val(optionList[key]);
                $(".optional-" + (key+1) + "-container").removeClass('hidden');
                Contact._RemainingFields -=1;
            }
            else if (key>0) {
                // hide the unused fields
                $(".optional-" + (key+1) + "-container").addClass('hidden');
                $(".contact-form").find("input#option_" + (key+1)).val('');
            }
        });

        if (this._RemainingFields=='0'){
            // Make sure all popovers are closed before disabling
            $(".add-opt-btn").each(function(){
                $(this).popover('hide').attr('disabled',true);
            });

        }

        $('.remaining-fields').html(this._RemainingFields);

        return;
    },

    deleteOption : function (Option) {
        var optionList = [];
        var x = 0;

        // Save the list, all but the deleted record
        optionList = this.getOptionArray(Option);

        var x = optionList.length;
        Contact._RemainingFields = Contact._MaxCustomFields;

        // Re-assign the form values without the deleted element
        $('.opt-field').each(function(key, optRecord){
            if (key < x){
                $(".contact-form").find("input#option_" + (key+1)).val(optionList[key]);
                $(".optional-" + (key+1) + "-container").removeClass('hidden');
                Contact._RemainingFields -=1;
            }
            else {
                // hide the unused fields
                if (key)
                    $(".optional-" + (key+1) + "-container").addClass('hidden');
                $(".contact-form").find("input#option_" + (key+1)).val('');
            }
        });

        $('.remaining-fields').html(this._RemainingFields);

        return;
    },

    showAlert : function (txt, icon, bckColor, fadeOut) {
        $(".ga-message").html(txt);
        if (icon) {
            $(".ga-icon").html(icon);
        }
        else {
            $(".ga-icon").html('<span class="fa fa-info-circle rpad-5"></span>');
        }
        if (bckColor) {
            $(".general-alert").css("background-color", bckColor);
        }
        else {
            $(".general-alert").css("background-color", '#347cb9');
        }

        $(".general-alert").removeClass('hidden').slideDown();
        if (typeof fadeOut === "undefined")
            setTimeout(function () {
                $(".user-alert").fadeOut().slideUp();
            }, 30000);

        return;
    },

    hideAlert : function () {
        $(".general-alert").slideUp();
    },

    getOptionArray : function(exclude){
        var x=0;
        var optionList = [];
        $('.opt-field').each(function(key, optRecord){
            if ($(optRecord).attr('data-option') != exclude && $(optRecord).val() != '') {
                optionList[x++] = $(optRecord).val();
            }
        });
        return optionList;
    },

    injectObjectToForm : function(){
        $('.contact-form').find('#id').val(this._id);
        $('.contact-form').find('input#name').val(this._name);
        $('.contact-form').find('input#email').val(this._email);
        $('.contact-form').find('input#phone').val(this._phone);
        $('.contact-form').find('input#option_1').val(this._option_1);
        $('.contact-form').find('input#option_2').val(this._option_2);
        $('.contact-form').find('input#option_3').val(this._option_3);
        $('.contact-form').find('input#option_4').val(this._option_4);
        $('.contact-form').find('input#option_5').val(this._option_5);
    },

    injectFormToObject : function(){

        $('.contact-form .form-input').each(function () {
            Contact[$(this).attr('name')] = $(this).val();
        });
        return;
    },

    injectTableToObject : function (id) {
        dataRow = $(".data-table-elements").find("tr[data-id=" + id + "]");
        this._id = id;
        this._name = $(dataRow).find(".data-name").html();
        this._email = $(dataRow).find(".data-email").html();
        this._phone = $(dataRow).find(".data-phone").html();
        this._option_1 = $(dataRow).find(".data-option_1").html();
        this._option_2 = $(dataRow).find(".data-option_2").html();
        this._option_3 = $(dataRow).find(".data-option_3").html();
        this._option_4 = $(dataRow).find(".data-option_4").html();
        this._option_5 = $(dataRow).find(".data-option_5").html();
    },
    
    resetForm : function(){

        $(".contact-form").find('.form-input').each(function (idx) {
            if ($(this).hasClass('opt-field')){
                var optBox = $(this).parentsUntil('opt-box');
                var optParent = $(optBox[0]).parent().parent();
                if (!optParent.hasClass('optional-1-container')) {
                    optParent.addClass('hidden');
                }
            }
            $(this).val('');
        });
        $(".add-field").attr('disabled', false);

        return;
    },

    search : function(){
        var text = $(".search-text").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('form input[name="_token"]').val()
            }
        });
        console.log('looking for: '+text);
        $.ajax({
            type: 'GET',
            url: '/search/?target='+text,
            // data: {target : text},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                // Contact.showAlert('Update complete for ' + Contact.name, '<i class="fa fa-info-circle"></i>');
                $('.contacts-data-container').html(data);
            },
            error: function (data) {
                if (data.status && data.status==200){
                    // bug in jquery
                    $('.contacts-data-container').html(data.responseText);
                    return true;
                }
                console.log('Error:', data);
                if (data.responseJSON)
                Contact.showAlert('Oops! ' + data.responseJSON.errors.target["0"],
                    '<i class="fa fa-exclemation"></i>','red',false)
            }
        });

    }
};
    // --------------------------------------------------------
    // Event Listeners
    // --------------------------------------------------------
    $('body').on('click',".add-btn", function(e){
        e.stopPropagation();
        Contact.resetForm();
        Contact.showModal();
        return false;
    });
    $('body').on('click',".edit-btn", function(e){
        e.stopPropagation();
        Contact.read($(this).attr("data-id"));
        return false;
    });
    $('body').on("click",".delete-btn", function(e){
        e.stopPropagation();
        Contact.delete($(this).attr("data-id"));
        return false;
    });
    $('body').on("click",".delete-opt-btn", function(e){
        e.stopPropagation();
        Contact.deleteOption($(this).attr("data-option"));
        return false;
    });
    $('body').on("click",".save-edit-btn", function(e){
        e.stopPropagation();
        Contact.update($('.contact-form input#id').val());
        return false;
    });
    $('body').on("click",".add-opt-btn", function(e){
        e.stopPropagation();
        Contact.addOption($(this).attr("data-option"));
        return false;
    });
    $('body').on("click",".ga-close",function(e){
        e.stopPropagation();
        $(".general-alert").slideUp();
        return false;
    })
    $('body').on("click",".search-btn", function(e){
        e.stopPropagation();
        Contact.search();
        return false;
    });
    $("body").on("click",".login-btn", function(e){
        localStorage.email =  $('form input#email').val();
    });
    // --------------------------------------------------------
    // The End !
    // --------------------------------------------------------

});