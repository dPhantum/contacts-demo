<?php
$addFieldTitle = "Add Custom Field";
$addFieldText = "Click here to add another custom field, below this one. You have 5 maximum optional fields.";
$removeFieldTitle = "Remove Option Field";
$removeFieldText = "Click here to remove this custom field.";
?>
<div id="contactEditor" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contact Information</h4>
            </div>
            <div class="modal-body editor-body">
                <form class="form-horizontal contact-form form">
                    {{ csrf_field() }}
                    <input class="form-input" type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <div class="name-container">
                            <div class="input-group">
                                <input id="name" type="text" class="form-control form-input" name="name"
                                       placeholder="Enter name" aria-label="Please enter name here" required autofocus>
                                <span class="input-group-addon"><i class="fa  fa-user-circle"></i> </span>
                            </div>
                            <span class="help-block-name">
                                        <strong class="msg"></strong>
                                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">E-Mail Address</label>

                        <div class="email-container">
                            <div class="input-group">
                                <input id="email" type="email" class="form-control form-input" name="email"
                                       placeholder="Enter Email Address" aria-label="Please enter email address"
                                       required>
                                <span class="input-group-addon"><i class="fa  fa-at"></i> </span>
                            </div>
                            <span class="help-block-email">
                                     <strong class="msg"></strong>
                                </span>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="control-label">Phone Number</label>

                        <div class="phone-container">
                            <div class="input-group">
                                <input id="phone" type="phone" class="form-control form-input" name="phone"
                                       placeholder="Enter Phone Number" aria-label="Please enter phone number" required>
                                <span class="input-group-addon"><i class="fa fa-phone"></i> </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <label for="optional" class="control-label">
                        Optional Fields (<i class='remaining-fields'>5</i> Available)
                    </label>

                    <div class="optional-1-container opt-box">
                        <div class="form-group">
                            <div class="input-group" role="group">
                                <input id="option_1" type="text" class="form-control form-input opt-field" name="option_1"
                                       placeholder="Enter text" aria-label="Enter optional text here" value="" data-option="1">
                                <span class="input-group-btn">
                                        <button class="btn btn-default add-opt-btn" type="button"  data-option="1"
                                                data-toggle="popover" data-placement="left" title="{{ $addFieldTitle }}"
                                                data-content="{{ $addFieldText }}">
                                            <i class="fa fa-plus-circle green"></i>
                                        </button>
                                        <button class="btn btn-default delete-opt-btn" type="button" data-option="1"
                                                data-toggle="popover" data-placement="top" title="{{ $removeFieldTitle }}"
                                                data-content="{{ $removeFieldText }}">
                                            <i class="fa fa-minus-circle red"></i>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="optional-2-container hidden  opt-box">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="option_2" type="text" class="form-control form-input opt-field" name="option_2"
                                       placeholder="Enter text" aria-label="Enter optional text here" value="" data-option="2">
                                <span class="input-group-btn">
                                        <button class="btn btn-default add-opt-btn" type="button"  data-option="2"
                                                data-toggle="popover" data-placement="left" title="{{ $addFieldTitle }}"
                                                data-content="{{ $addFieldText }}">
                                            <i class="fa fa-plus-circle green"></i>
                                        </button>
                                        <button class="btn btn-default delete-opt-btn" type="button" data-option="2"
                                                data-toggle="popover" data-placement="top" title="{{ $removeFieldTitle }}"
                                                data-content="{{ $removeFieldText }}">
                                            <i class="fa fa-minus-circle red"></i>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="optional-3-container hidden opt-box">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="option_3" type="text" class="form-control form-input opt-field" name="option_3"
                                       placeholder="Enter text" aria-label="Enter optional text here" value="" data-option="3">
                                <span class="input-group-btn">
                                        <button class="btn btn-default add-opt-btn" type="button" data-option="3"
                                                data-toggle="popover" data-placement="left" title="{{ $addFieldTitle }}"
                                                data-content="{{ $addFieldText }}">
                                            <i class="fa fa-plus-circle green"></i>
                                        </button>
                                        <button class="btn btn-default delete-opt-btn" type="button" data-option="3"
                                                data-toggle="popover" data-placement="top" title="{{ $removeFieldTitle }}"
                                                data-content="{{ $removeFieldText }}">
                                            <i class="fa fa-minus-circle red"></i>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="optional-4-container hidden opt-box">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="option_4" type="text" class="form-control form-input opt-field" name="option_4"
                                       placeholder="Enter text" aria-label="Enter optional text here" value="" data-option="4">
                                <span class="input-group-btn">
                                        <button class="btn btn-default add-opt-btn" type="button" data-option="4"
                                                data-toggle="popover" data-placement="left" title="{{ $addFieldTitle }}"
                                                data-content="{{ $addFieldText }}">
                                            <i class="fa fa-plus-circle green"></i>
                                        </button>
                                        <button class="btn btn-default delete-opt-btn" type="button" data-option="4"
                                                data-toggle="popover" data-placement="top" title="{{ $removeFieldTitle }}"
                                                data-content="{{ $removeFieldText }}">
                                            <i class="fa fa-minus-circle red"></i>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="optional-5-container hidden opt-box">
                        <div class="form-group">
                            <div class="input-group">
                                <input id="option_5" type="text" class="form-control form-input opt-field" name="option_5"
                                       placeholder="Enter text" aria-label="Enter optional text here" value="" data-option="5">
                                <span class="input-group-btn">
                                        <button class="btn btn-default add-opt-btn" type="button" data-option="5"
                                                data-toggle="popover" data-placement="left" title="{{ $addFieldTitle }}"
                                                data-content="{{ $addFieldText }}">
                                            <i class="fa fa-plus-circle green"></i>
                                        </button>
                                        <button class="btn btn-default delete-opt-btn" type="button" data-option="5"
                                                data-toggle="popover" data-placement="top" title="{{ $removeFieldTitle }}"
                                                data-content="{{ $removeFieldText }}">
                                            <i class="fa fa-minus-circle red"></i>
                                        </button>
                                    </span>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success save-edit-btn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
