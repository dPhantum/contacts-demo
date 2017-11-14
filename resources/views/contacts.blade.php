@extends('layouts.app')

@section('content')
    <div class="general-alert hidden">
        <i class="ga-icon"></i>
        <span class="ga-message">This is a general message</span>
        <span class="close pull-right ga-close">X</span>
    </div>
    <div class="container">
        <h1 class="contacts-header">Contacts</h1>
        <div class="row animated fadeIn">
            <div class="col-md-12 contacts-container">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="search-container">
                            <div class="search-field-container  pull-left">


                                <div class="input-group">
                                    <input id="search-text" type="text" class="form-control search-text" name="search-text"
                                           placeholder="Enter name, email or phone" aria-label="Enter name, email or phone">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary search-btn" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="add-btn-container pull-right">
                                <button class="btn btn-success add-btn">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Contact
                                </button>
                            </div>

                        </div>

                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @include('contact-list')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('contact-editor')


@endsection
