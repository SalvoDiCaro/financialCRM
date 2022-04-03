<div class="box">
    <div class="box-header">
        <h3 class="box-title "><strong>{{ $rubric->name }}</strong></h3>
        <div class="pull-right">
            <a class="btn btn-success btn-sm" href="{{ route('contacts.create', $rubric->id) }}"
                title="Create Contact"><i class="fa fa-plus"></i></a>
            <form action="{{ route('rubrics.import', $rubric->id) }}" id="inputform" method="POST"
                enctype="multipart/form-data" style="display:inline">
                <input type="file" name="vcard" style="display:none;" id="file" />
                <a class="btn btn-warning btn-sm" style="color: white" title="Import Contact"
                    onClick="thisFileUpload()"><i class="fa fa-cloud"></i></a>
                @csrf
            </form>

        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-bordered table1" style="width:100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created at</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->created_at }}</td>
                        <td class="text-right">
                            {!! Form::model($contact, ['method' => 'POST', 'route' => ['contacts.destroy', $contact->id], 'id' => 'deleteForm']) !!}
                            <a class="btn btn-warning btn-sm" title="Show Contact"
                                href="{{ route('contacts.show', $contact->id) }}">
                                <i class="fa fa-id-badge"></i>
                            </a>
                            @canSee($rubric->id)
                            <a class="btn btn-success btn-sm" title="Edit Contact"
                                href="{{ route('contacts.edit', $contact->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-info btn-sm" title="Export Contact"
                                href="{{ route('contacts.export', $contact->id) }}">
                                <i class="fa fa-download"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Delete Contact', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'myFunction()']) }}
                        @endcan
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@section('style')
<style>
    img {
        display: block;
        max-width: 100%;
        pointer-events: none;
        cursor: default;
    }

</style>
@endsection

@section('scripts')
<script>
    function myFunction() {
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                document.getElementById("deleteForm").submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your file is safe :)',
                    'error'
                )
            }
        })
    }
</script>
<script>
    $(document).ready(function() {
        $('input[type=file]').change(function() {
            if (this.files[0].name.length) this.form.submit();
        });
    });

    function thisFileUpload() {
        document.getElementById("file").click();
    };

    function showImport() {
        document.getElementById("inputform").style.display = "block";
    };

    $(document).ready(function() {
        $('.table1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'info': false,
            'autoWidth': true,
            'responsive': true,
            'columnDefs': [{
                'targets': 2,
                /* column index */
                'orderable': false,
                /* true or false */
            }]
        });
    });
</script>
@endsection
