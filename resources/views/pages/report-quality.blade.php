@extends('layouts.master')

@section('content')
<!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content">

        @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

        @endcomponent

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <!-- row -->

            <div class="row">

                <article class="col-sm-12 col-md-12">

                    @component('components.jarviswidget',
                    ['id' => 1, 'icon' => 'fa-table', 'title' => 'Report'])
                    <div class="widget-body">

                        <form id="search-form-report" class="smart-form" action="#"
                              url="{!! route('report.filter') !!}">
                            <div class="row">
                                <div id="reportrange" class="pull-left"
                                     style="background: #fff; cursor: pointer; padding: 10px; border: 1px solid #ccc; margin: 10px 15px">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span class="registered_date"></span> <b class="caret"></b>
                                </div>
                            </div>
                            <div class="row">
                                <section class="col col-2">
                                    <label class="label">Source</label>
                                    <select name="source_id" class="select2" style="width: 280px" id="source_id" tabindex="1" autofocus
                                            data-url="{!! route('ajax-getFilterSource') !!}">
                                        <option value="all">All</option>
                                        @foreach($sources as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <i></i>
                                </section>
                                <section class="col col-2">
                                    <label class="label">Team</label>
                                    <select name="team_id" class="select2" id="team_id" style="width: 280px" tabindex="2"
                                            data-url="{!! route('ajax-getFilterTeam') !!}">
                                        <option value="all">All</option>
                                        @foreach($teams as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <i></i>
                                </section>
                                <section class="col col-2">
                                    <label class="label">Marketer</label>
                                    <select name="marketer_id" id="marketer_id" class="select2" style="width: 280px" tabindex="3">
                                        <option value="all">All</option>
                                        @foreach($marketers as $item)
                                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                                        @endforeach
                                    </select>
                                    <i></i>
                                </section>
                                <section class="col col-2">
                                    <label class="label">Campaign</label>
                                    <select name="campaign_id" id="campaign_id" class="select2" style="width: 280px" tabindex="4"
                                            data-url="{!! route('ajax-getFilterCampaign') !!}">
                                        <option value="all">All</option>
                                        @foreach($campaigns as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <i></i>
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
                        {{--<div style="position: relative">
                            <form action="{{ route('report.export')}}" enctype="multipart/form-data">
                                <input type="hidden" name="source_id">
                                <input type="hidden" name="marketer_id">
                                <input type="hidden" name="campaign_id">
                                <input type="hidden" name="team_id">
                                <input type="hidden" name="registered_date">
                                <div style="position: absolute; right: 75px; bottom: 0px;">
                                    <button class="btn btn-success" type="submit"
                                            style="background-color: #3276b1;border-color: #2c699d;">Export Excel
                                    </button>
                                </div>
                            </form>
                        </div>--}}
                        <div class="loading" style="display: none">
                            <div class="col-md-12 text-center">
                                <img id="img_ajax_upload" src="{{ url('/img/loading/rolling.gif') }}" alt="" style="width: 2%;"/>
                            </div>
                        </div>
                        <hr>
                        <div class="wrapper_report">
                            <table id="table_report" class="table "
                                   width="100%">
                                <thead>
                                    <tr>
                                        <th>Source</th>
                                        <th>Team</th>
                                        <th>MKTer</th>
                                        <th>Campaign</th>
                                        <th>Subcampaign</th>
                                        <th>Ad</th>
                                        <th>C1</th>
                                        <th class="long">C1 Cost (VND)</th>
                                        <th>C2</th>
                                        <th class="long">C2 Cost (VND)</th>
                                        <th>C2/C1 (%)</th>
                                        <th>C3</th>
                                        <th class="long">C3 Cost (VND)</th>
                                        <th>C3B</th>
                                        <th class="long">C3B Cost (VND)</th>
                                        <th>C3/C2 (%)</th>
                                        <th>L1</th>
                                        <th>L3</th>
                                        <th>L8</th>
                                        <th>L3/L1 (%)</th>
                                        <th>L8/L1 (%)</th>
                                        <th class="long">Spent (USD)</th>
                                        <th class="long">Revenue (THB)</th>
                                        <th>ME/RE (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($report as $id => $item)

                                    <tr id="ad-{{ $id }}">
                                        <td>{{ $item->source }}</td>
                                        <td>{{ $item->team }}</td>
                                        <td>{{ $item->marketer }}</td>
                                        <td>{{ $item->campaign }}</td>
                                        <td>{{ $item->subcampaign }}</td>
                                        <td>{{ $item->ad }}</td>
                                        <td>{{ number_format($item->c1) }}</td>
                                        <td>{{ number_format($item->c1_cost, 2) }}</td>
                                        <td>{{ number_format($item->c2) }}</td>
                                        <td>{{ number_format($item->c2_cost, 2) }}</td>
                                        <td>{{ $item->c2_c1 }}</td>
                                        <td>{{ number_format($item->c3) }}</td>
                                        <td>{{ number_format($item->c3_cost, 2) }}</td>
                                        <td>{{ number_format($item->c3b) }}</td>
                                        <td>{{ number_format($item->c3b_cost, 2) }}</td>
                                        <td>{{ $item->c3_c2 }}</td>
                                        <td>{{ $item->l1 }}</td>
                                        <td>{{ $item->l3 }}</td>
                                        <td>{{ $item->l8 }}</td>
                                        <td>{{ $item->l3_l1 }}</td>
                                        <td>{{ $item->l8_l1 }}</td>
                                        <td>{{ number_format($item->spent, 2) }}</td>
                                        <td>{{ number_format($item->revenue) }}</td>
                                        <td>{{ $item->me_re }}</td>
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

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

@endsection

@section('script')

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ asset('js/reports/report.js') }}"></script>
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

</script>

@stop
