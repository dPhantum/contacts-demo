<?php
$counter=0;
$emptySet=false;
?>
<div class="contacts-data-container">
    <div class="contact-table-container">
        <table class="table table-condensed table-striped table-hover data-table-elements">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if (count($contacts)<=0)
                <?php $emptySet= true; ?>
                <tr data-id="0" data-row-id="0" class="data-row contact-clonee hidden">
                    <td class="data-name">
                    </td>
                    <td class="data-email"></td>
                    <td class="data-phone"></td>
                    <td class="data-opt data-option_1 hidden"></td>
                    <td class="data-opt data-option_2 hidden"></td>
                    <td class="data-opt data-option_3 hidden"></td>
                    <td class="data-opt data-option_4 hidden"></td>
                    <td class="data-opt data-option_5 hidden"></td>
                    <td>
                        <button class="btn btn-xs btn-info edit-btn" data-id="0">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-xs btn-danger delete-btn" data-id="0">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
            @else
                @foreach($contacts as $contact)
                    <tr data-id="{{ $contact['id'] }}" data-row-id="{{ ++$counter }}" class="data-row">
                        <td class="data-name">{{ $contact['name'] }}</td>
                        <td class="data-email">{{ $contact['email'] }}</td>
                        <td class="data-phone">{{ $contact['phone'] }}</td>
                        <td class="data-opt data-option_1 hidden">{{ $contact['option_1'] }}</td>
                        <td class="data-opt data-option_2 hidden">{{ $contact['option_2'] }}</td>
                        <td class="data-opt data-option_3 hidden">{{ $contact['option_3'] }}</td>
                        <td class="data-opt data-option_4 hidden">{{ $contact['option_4'] }}</td>
                        <td class="data-opt data-option_5 hidden">{{ $contact['option_5'] }}</td>
                        <td>
                            <button class="btn btn-xs btn-info edit-btn" data-id="{{ $contact['id'] }}" >
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-xs btn-danger delete-btn" data-id="{{ $contact['id'] }}" >
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr data-id="0" data-row-id="0" class="hidden contact-clonee">
                    <td class="data-name"></td>
                    <td class="data-email"></td>
                    <td class="data-phone"></td>
                    <td class="data-opt data-option_1 hidden"></td>
                    <td class="data-opt data-option_2 hidden"></td>
                    <td class="data-opt data-option_3 hidden"></td>
                    <td class="data-opt data-option_4 hidden"></td>
                    <td class="data-opt data-option_5 hidden"></td>
                    <td>
                        <button class="btn btn-xs btn-info edit-btn" data-id="">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-xs btn-danger delete-btn" data-id="">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>

                </tr>
            @endif
            @if($emptySet)
                <div class="alert alert-info empty-set" role="alert">
                    <b class="alert-link">No contacts found.</b>
                </div>
            @endif
            </tbody>
        </table>
        <span class="hidden row-counter" data-counter="{{ ++$counter }}"></span>
    </div>
    <div class="col-md-12">
        <div class="center-block text-center">
            {{ $contacts->render() }}
        </div>

    </div>
</div>
