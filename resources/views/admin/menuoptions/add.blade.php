{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

<style>
/* Custom Radio Button */
.radio
{
    display: none;
}
.radio:checked + label {
  background: dimgrey!important;
  color: #fff;
}
</style>


{{-- Section of Add Topping --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Group Topping</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('option') }}">Menu Options</a></li>
                            <li class="breadcrumb-item active">Insert</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Insert Topping Section --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('inserttopping') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fas fa-pencil-alt pr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right;">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('option') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="groupName"><span class="text-danger">*</span> Group Name</label>
                                        <input type="text" name="groupName" id="groupName" class="form-control {{ ($errors->has('groupName')) ? 'is-invalid' : '' }}">
                                        @if ($errors->has('groupName'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('groupName') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{-- Tabs Link --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items" aria-selected="true">Items</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="false">Options</a>
                                            </li>
                                        </ul>
                                        {{-- End Tabs Link --}}

                                        {{-- Tab Content --}}
                                        <div class="tab-content pt-4" id="myTabContent">
                                            {{-- Items Tab --}}
                                            <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Price Main</th>
                                                                    <th>Order</th>
                                                                    <th>Sub Options</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="size-value-row_12" id="listTopping">

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5" class="text-center">
                                                                        <div class="btn-group">
                                                                            <input type="number" name="addNumber" value="1" min="1"/>

                                                                            <button type="button" style="margin-left: 20px" onclick="addoption();" class="btn btn-primary">
                                                                                <i class="fa fa-plus-circle"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Items Tab --}}

                                            {{-- Options Tab --}}
                                            <div class="tab-pane fade show" id="options" role="tabpanel" aria-labelledby="options-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-stripped table-hover">
                                                            <tr>
                                                                <th><label>Print Group Title</label></th>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <input type="radio" class="radio" id="enable" name="show_group_title" value="1" />
                                                                        <label class="btn btn-sm" style="background: green;color:white;" for="enable">Enable</label>
                                                                        <input type="radio" class="radio" id="disable" name="show_group_title" value="0" checked />
                                                                        <label class="btn btn-sm" style="background: red;color: white;" for="disable">Disable</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="group_title_color">Title Front Color</label>
                                                                </th>
                                                                <td>
                                                                    <input class="form-control" type="color"
                                                                    name="group_title_color" value="">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="topping_header_message">Header Message</label>
                                                                </th>
                                                                <td>
                                                                    <input type="text" name="topping_header_message" value="" class="form-control" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="topping_footer_message">Footer Message:</label>
                                                                </th>
                                                                <td>
                                                                    <input type="text" name="topping_footer_message" value=""  class="form-control"/>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Options Tab --}}
                                        </div>
                                        {{-- End Tab Content --}}
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


<script  src="https://cdnjs.cloudflare.com/ajax/libs/color-js/1.0.1/color.min.js"></script>

{{-- SCRIPT --}}
<script type="text/javascript">

    // Add Topping Option
    var number_option = 0;
    // $('.showOptions').hide();

    function addoption()
    {
        var add_number = $('input[name="addNumber"]').val();
        if (add_number > 10)
        {
            alert(`You can't Add more then 10 items at a time`);
        }
        else
        {
            for (i = 0; i < add_number; i++)
            {
                number_option++;
                var html = '<tr class="option_' + number_option +
                    '"><td class="align-middle"><input type="text" value="" name="optiontopping['+number_option+'][name]" class="form-control" placeholder="Item Name" /></td>';
                html += '<td class="align-middle"><input type="text" value="" name="optiontopping['+number_option+'][price_main]" class="form-control" placeholder="Price" /></td>';
                html += '<td class="align-middle"><input type="text" value="" class="form-control" name="optiontopping['+number_option+'][order]" placeholder="Sort Order" /></td>';
                html += '<td><select name="optiontopping['+number_option+'][sub_option][]" multiple="multiple" class="form-control">@foreach($suboptions as $suboption)<option value="{{ $suboption->id_topping }}">{{ $suboption->name_topping }}</option>@endforeach</select></td>';
                html += '<td class="align-middle"><a onclick="$(\'.option_' + number_option +
                    '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
                $('#listTopping').append(html);
            }
        }
    }

    function showOptions(e) {
        $('.toppingsTab').removeClass('active');
        $('.showOptions').show();
        $('.showItems').hide();
        $(e).addClass('active');
    }

    function showItems(e) {
        $('.toppingsTab').removeClass('active');
        $('.showItems').show();
        $('.showOptions').hide();
        $(e).addClass('active');
    }
</script>
{{-- END SCRIPT --}}
