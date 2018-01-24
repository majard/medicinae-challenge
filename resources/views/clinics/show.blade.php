@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        Current Clinics
    </div>

    <div class="panel-body">
        <table class="table table-striped clinic-table">

            <!-- Table Headings -->
            <thead>
                <th> Clinic</th>
                <th>&nbsp;</th>
            </thead>

            <!-- Table Body -->
            <tbody>
                <tr>
                    <!-- Clinic Name -->
                    <td class="table-text">
                        <div>{{ $clinic->nome }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $clinic->cnpj }}</div>
                    </td>                            
                    
                        <td>                        
                            <button type="button" class="btn btn-danger delete" value="{{$clinic->id}}" data-dismiss="modal">
                                <span id="" class='glyphicon glyphicon-trash'></span> Delete
                            </button>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
// delete a post
    $(document).ready(function() {
        
        $(".delete").click(function(){
            
            var id = $(this).val();
        
            $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
            })


            $.ajax({
                url: '/clinicas/' + id,

                type: 'DELETE',

                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data['id']).remove();
                }
            });
        });
    });
</script>
@endsection