@extends('layouts.master')

@section('content')
<!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content">

        @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
        <a class="btn btn-primary btn-lg pull-right header-btn hidden-mobile"
           data-toggle="modal"
           data-target="#addModal"><i
                    class="fa fa-plus fa-lg"></i> Create Contact</a>
        @endcomponent

        @include('layouts.errors')

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <!-- row -->

            <div class="row">

                <article class="col-sm-12 col-md-12">

                    @component('components.jarviswidget',
                    ['id' => 1, 'icon' => 'fa-table', 'title' => 'C3 Produced'])
                    <div class="widget-body no-padding">
                        <form id="search-form-c3" class="smart-form" action="#">
                            <div class="row">
                                <div id="reportrange" class="pull-left"
                                     style="background: #fff; cursor: pointer; padding: 10px; border: 1px solid #ccc; margin: 10px 15px">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span class="registered_date"></span> <b class="caret"></b>
                                </div>
                            </div>
                            <div class="row">
                                <section class="col col-3">
                                    <label class="label">Source</label>
                                    <label class="select"> <i class="icon-append fa fa-user"></i>
                                        <select name="source_id">
                                            <option value="">All</option>
                                            @foreach($sources as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <i></i>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Team</label>
                                    <label class="select"> <i class="icon-append fa fa-user"></i>
                                        <select name="team_id">
                                            <option value="">All</option>
                                            @foreach($teams as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <i></i>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Marketer</label>
                                    <label class="select"> <i class="icon-append fa fa-user"></i>
                                        <select name="marketer_id">
                                            <option value="">All</option>
                                            @foreach($marketers as $item)
                                            <option value="{{ $item->id }}">{{ $item->username }}</option>
                                            @endforeach
                                        </select>
                                        <i></i>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Campaign</label>
                                    <label class="select"> <i class="icon-append fa fa-user"></i>
                                        <select name="campaign_id">
                                            <option value="">All</option>
                                            @foreach($campaigns as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <i></i>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary btn-sm" type="submit" style="margin-right: 15px">
                                        <i class="fa fa-filter"></i>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('contacts.export')}}" enctype="multipart/form-data">
                            <input type="hidden" name="source_id">
                            <input type="hidden" name="marketer_id">
                            <input type="hidden" name="campaign_id">
                            <input type="hidden" name="team_id">
                            <input type="hidden" name="registered_date">
                            <button class="btn btn-success" type="submit">Export</button>
                        </form>
                        <hr>
                        <div class="wrapper">
                            <table id="table_campaigns" class="table table-striped table-bordered table-hover"
                                   width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Registered at</th>
                                        <th>Current level</th>
                                        <th>Marketer</th>
                                        <th>Campaign</th>
                                        <th>Channel</th>
                                        <th>Ads</th>
                                        <th>Landing page</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $item)
                                    <tr id="contact-{{ $item->id }}">
                                        <td><a href="{{ route("contacts-details", $item->id) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ Date('d-m-Y H:i:s', strtotime($item->registered_date)) }}</td>
                                        <td>{{ $item->current_level }}</td>
                                        <td>{{ $item->marketer_name }}</td>
                                        <td>{{ $item->campaign_name }}</td>
                                        <td>{{ $item->subcampaign_name }}</td>
                                        <td>{{ $item->ad_name }}</td>
                                        <td>{{ $item->landingpage_name }}</td>
                                        <td>
                                            {{--@permission('edit-review')--}}
                                            <a data-toggle="modal" class='btn btn-xs btn-default'
                                               data-target="#addModal"
                                               data-item-id="{{ $item->id }}"
                                               data-original-title='Edit Row'><i
                                                        class='fa fa-pencil'></i></a>
                                            {{--<a data-toggle="modal" class='btn btn-xs btn-default'
                                                   data-target="#deleteModal"
                                                   data-item-id="{{ $item->id }}"
                                                   data-item-name="{{ $item->name }}"
                                                   data-original-title='Delete Row'><i
                                                        class='fa fa-times'></i></a>--}}
                                            {{--@endpermission--}}
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endcomponent

                </article>

            </div>

            <!-- end row -->

        </section>
        <!-- end widget grid -->

        {{--@include('components.form-create-campaign', ['type' => null])--}}

        {{--
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h3 class="modal-title"> Are you sure you want to delete this campaign?</h3>
                    </div>
                    <div class="modal-footer">
                        <form method="post" action="">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value=""/>
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancel
                            </button>

                        </form>
                    </div>

                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->
        </div>
        --}}

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

@endsection

@section('script')

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ asset('js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    $(document).ready(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('Y-M-D') + '  ' + end.format('Y-M-D'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'right',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                "This Week": [moment().startOf("week"), moment().endOf("week")],
                "Last Week": [moment().subtract(1, "week").startOf("week"), moment().subtract(1, "week").endOf("week")],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });

        $(document).ready(function () {

        /* BASIC ;*/
        var responsiveHelper_table_campaign = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        $('#table_campaigns').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>" +
            "t" +
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_table_campaign) {
                    responsiveHelper_table_campaign = new ResponsiveDatatablesHelper($('#table_campaigns'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_table_campaign.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_table_campaign.respond();
            },
            "order": [[0, "desc"]]
        });


//        $('head').append('<link rel="stylesheet" href="{{ asset('js/plugin/selectize/css/selectize.bootstrap3.css') }}">');

        /* END BASIC */
    });

    $(document).ready(function () {
        $('#search-form-c3').submit(function (e) {
            e.preventDefault();
            var source_id = $('select[name="source_id"]').val();
            var team_id = $('select[name="team_id"]').val();
            var marketer_id = $('select[name="marketer_id"]').val();
            var campaign_id = $('select[name="campaign_id"]').val();
            var registered_date = $('.registered_date').text();

            $('input[name="source_id"]').val(source_id);
            $('input[name="team_id"]').val(team_id);
            $('input[name="marketer_id"]').val(marketer_id);
            $('input[name="campaign_id"]').val(campaign_id);
            $('input[name="registered_date"]').val(registered_date);


            var url = "{!! route('contacts.filter') !!}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    source_id: source_id,
                    team_id: team_id,
                    marketer_id: marketer_id,
                    campaign_id: campaign_id,
                    registered_date: registered_date
                }
            }).done(function (response) {
                $('.wrapper').html(response);
            });
        });
    })

</script>
@include('components.script-campaign')
@stop
