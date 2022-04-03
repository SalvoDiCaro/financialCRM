<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Creditodigital </title>
    <link rel="icon" href="https://e7.pngegg.com/pngimages/91/514/png-clipart-blue-and-white-illustration-of-earth-social-science-global-perspectives-business-supply-chain-industry-blue-earth-blue-computer-network-thumbnail.png"
        type="image/png" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!--DataTables--!>
  <link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap.min.css">

  <!--Cropper--!>
  <meta name="_token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
  <link rel="stylesheet" href="/resources/css/app.css">
  <!--Chosen--!>
  <link rel="stylesheet" href="/plugins/chosen/chosen.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">
    <!-- Fonts -->
    @yield('style')
    <style>
        input,textarea {
            text-transform: uppercase;
        }

    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!--SweetAlert--!>
  <link rel="stylesheet" href="/plugins/SweetAlert/dist/sweetalert2.min.css">

  <!--CheckBox--!>
  <link href="/plugins/iCheck/square/aero.css" rel="stylesheet">

  <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @if (Auth::user())
            @include('layouts.log')
        @else
            @include('layouts.nolog')
        @endif

        <!-- Main content -->
        <section class="content container-fluid">
            @if ($message = Session::get('success'))
                <div class="callout callout-success">
                    <h4>Operazione effettuata con successo!</h4>
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i
                            class="icon fa fa-times-circle"></i></button>
                    <h4><i class="icon fa fa-ban"></i>{{ session('error') }}</h4>
                    {{ $message }}
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i
                            class="icon fa fa-times-circle"></i></button>
                    <strong>ATTENZIONE!</strong> Ci sono dei problemi con i dati inseriti.<br><br>
                    <ul style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li><i class="icon fa fa-ban"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Creditodigital</strong>

    </footer>

    </div>


    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Slimscroll -->
    <script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/dist/js/demo.js"></script>
    <script src="/plugins/iCheck/icheck.js"></script>
    <!-- fullCalendar -->
    <script src="../bower_components/moment/moment.js"></script>
    <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--DataTable-->
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <!--Chosen-->
    <script src="/plugins/chosen/chosen.jquery.js"></script>
    <script src="/plugins/chosen/docsupport/prism.js"></script>
    <script src="/plugins/chosen/docsupport/init.js"></script>
    <script src="/plugins/chosen/chosen.jquery.js"></script>

    <!--Cropper-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
        integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <!--SweetAlert--!>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>



<!--AlertTimer-->
    <script type="text/javascript">
        $(document).ready(function() {

            window.setTimeout(function() {
                $(".callout").fadeTo(1000, 0).slideUp(1000, function() {
                    $(this).remove();
                });
            }, 3000);

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(document.body).on('keyup', 'input:not[type=date]', function toUpper() {
                this.value = this.value.toUpperCase();
              });

              $(document.body).on('keyup', 'textarea', function toUpper() {
                this.value = this.value.toUpperCase();
              });

              $('option').text(function(i,oldtext){
                return oldtext.toUpperCase();
              });
        });


        $("input[data-type='currency']").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() {
            formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }


        // function formatCurrency(input, blur) {
        // // appends € to value, validates decimal side
        // // and puts cursor back in right position.

        // // get input value
        // var input_val = input.val();

        // // dont validate empty input
        // if (input_val === "") { return; }

        // // original length
        // var original_len = input_val.length;

        // // initial caret position
        // var caret_pos = input.prop("selectionStart");

        // // check for decimal
        // if (input_val.indexOf(",") >= 0) {

        //     // get position of first decimal
        //     // this prevents multiple decimals from
        //     // being entered
        //     var decimal_pos = input_val.indexOf(",");

        //     // split number by decimal point
        //     var left_side = input_val.substring(0, decimal_pos);
        //     var right_side = input_val.substring(decimal_pos);

        //     // add commas to left side of number
        //     left_side = formatNumber(left_side);

        //     // validate right side
        //     right_side = formatNumber(right_side);

        //     // On blur make sure 2 numbers after decimal
        //     if (blur === "blur") {
        //     right_side += "00";
        //     }

        //     // Limit decimal to only 2 digits
        //     right_side = right_side.substring(0, 2);

        //     // join number by .
        //     input_val = "€ " + left_side + "," + right_side;

        // } else {
        //     // no decimal entered
        //     // add commas to number
        //     // remove all non-digits
        //     input_val = formatNumber(input_val);
        //     input_val = "€ " + input_val;

        //     // final formatting
        //     if (blur === "blur") {
        //     input_val += ",00";
        //     }
        // }

        // // send updated string to input
        // input.val(input_val);

        // // put caret back in the right position
        // var updated_len = input_val.length;
        // caret_pos = updated_len - original_len + caret_pos;
        // input[0].setSelectionRange(caret_pos, caret_pos);
        // }

    </script>

    <!--SweetAlert--!>
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success ',
            cancelButton: 'btn btn-danger '
        },
        buttonsStyling: true
    })

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
                document.getElementById("myForm").submit();
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
@yield('scripts')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>

</html>
