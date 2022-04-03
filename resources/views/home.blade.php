@extends('layouts.app')
@section('content')
    <?php
    setlocale(LC_TIME, 'it_IT.utf8', 'ita');
    ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ $weekly_leads }}</h3>

                                <p>Lead negli ultimi 7 giorni</p>
                                <p>
                                    @if ($previous_weekly_leads < $weekly_leads)
                                        +
                                        {{ ($weekly_leads - $previous_weekly_leads / ($previous_weekly_leads > 0 ? $previous_weekly_leads : 1)) * 100 }}
                                    @else
                                        -
                                        {{ ($previous_weekly_leads - $weekly_leads / ($weekly_leads > 0 ? $weekly_leads : 1)) * 100 }}
                                    @endif % della precedente
                                </p>

                            </div>
                            <div class="icon">
                                <i class="fa fa-clipboard"></i>
                            </div>
                            <a href="{{ route('leads.index') }}" class="small-box-footer">
                                Scopri di più <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ $instances_to_work }}</h3>
                                <p>Richieste su cui lavorare</p>
                                <p>in attesa di aggiornamento</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pin"></i>
                            </div>
                            <a href="{{ route('instances.index') }}" class="small-box-footer">
                                Scopri di più <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $dealers_available }}</h3>
                                <p>Agenzie disponibili</p>
                                <p>(assegnabili)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-email-unread"></i>
                            </div>
                            <a href="{{ route('dealers.index') }}" class="small-box-footer">
                                Scopri di più <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>{{ $dealers_assigned }}</h3>
                                <p>Agenzie prese in carico</p>
                                <p>(auto-assegnate)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ribbon-b"></i>
                            </div>
                            <a href="{{ route('commitments.index') }}" class="small-box-footer">
                                Scopri di più <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Seleziona periodo:</strong>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-clock"></i></span>
                                {!! Form::select('period', $periods, $period, ['class' => 'form-control period', 'onchange' => 'addPeriod(this.value);']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Seleziona dato:</strong>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion ion-clock"></i></span>
                                {!! Form::select(
    'period',
    [
        'Pratiche' => 'Pratiche',
        'Lead' => 'Lead',
        'Polizze' => 'Polizze',
    ],
    $state,
    ['class' => 'form-control state', 'onchange' => 'addState(this.value);'],
) !!}
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->agent_code == '00000000')
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Seleziona Agente:</strong>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ion ion-person"></i></span>
                                    {!! Form::select('agent', $agents, $agent, ['placeholder' => ' Tutti', 'class' => 'form-control agent', 'onchange' => 'addAgent(this.value);']) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($state == 'Pratiche')

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($annual_amount, 0, ',', '.') }}</h3>
                                    <p>Totale erogato mutui</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <!-- Colori bg fuchsia teal light-blue maroon -->
                                <div class="inner">
                                    <h3>{{ $annual_practices }}</h3>
                                    <p>Pratiche totali</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-compose"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($avg_amount, 0, ',', '.') }}</h3>
                                    <p>Erogato medio</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $avg_mutual }}</h3>
                                    <p>Durata media mutui</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>{{ $avg_ltv }}%</h3>
                                    <p>LTV medio</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-compose"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ $avg_ltv_fin }}%</h3>
                                    <p>LTV fin medio</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-compose"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-light-blue">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($avg_inquest, 0, ',', '.') }}</h3>
                                    <p>Istruttoria media</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ $percent_digital }}%</h3>
                                    <p>Pratiche digitali</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($state == 'Polizze')
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($annual_cpi_amount, 0, ',', '.') }}</h3>
                                    <p>Totale importi CPI</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $annual_cpi_number }}</h3>
                                    <p>Totale numero CPI</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($avg_cpi, 0, ',', '.') }}</h3>
                                    <p>Premio CPI medio</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $avg_policies }}</h3>
                                    <p>Media polizze per pratica</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($state == 'Lead')
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($annual_cpi_amount, 0, ',', '.') }}</h3>
                                    <p>Lead ottenuti</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $annual_cpi_number }}</h3>
                                    <p>Lead convertiti</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3>{{ '€ ' . number_format($avg_cpi, 0, ',', '.') }}</h3>
                                    <p>Lead diretti</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $avg_policies }}</h3>
                                    <p>Lead indiretti</p>
                                    <p>{{ is_numeric($period) ? ucfirst(strftime('%B', mktime(0, 0, 0, $period))) . ' ' . date('Y') : $period }}
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="{{ route('practices.index') }}" class="small-box-footer">
                                    Scopri di più <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Lead da lavorare</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->

                    <ul class="todo-list">
                        @foreach ($leads as $lead)
                            <li>
                                <!-- todo text -->
                                <a href="{{ route('leads.show', $lead->id) }}">
                                    <span class="text">{{ $lead->name }} {{ $lead->surname }}</span>
                                </a>
                                <!-- Emphasis label -->
                                @if ($lead->date_last_note)
                                    @if ($lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) > 1440)
                                        <small class="label label-danger"><i class="fa fa-clock-o"></i>
                                            {{ (int) ($lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) / 1440) }}
                                            giorno/i
                                        @elseif ($lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) > 60)
                                            <small class="label label-warning"><i class="fa fa-clock-o"></i>
                                                {{ (int) ($lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) / 60) }}
                                                ora/e
                                            @elseif($lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) >= 1)
                                                <small class="label label-info"><i class="fa fa-clock-o"></i>
                                                    {{ $lead->date_last_note->diffInMinutes(date('Y-m-d H:i:s')) }}
                                                    minuto/i
                                                @else
                                                    <small class="label label-success"><i class="fa fa-clock-o"></i>
                                                        adesso
                                    @endif
                                @else
                                    @if (isset($lead->updated_at) && $lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) > 1440)
                                        <small class="label label-danger"><i class="fa fa-clock-o"></i>
                                            {{ (int) ($lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) / 1440) }}
                                            giorno/i
                                        @elseif (isset($lead->updated_at) && $lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) > 60)
                                            <small class="label label-warning"><i class="fa fa-clock-o"></i>
                                                {{ (int) (isset($lead->updated_at) && $lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) / 60) }}
                                                ora/e
                                            @elseif(isset($lead->updated_at) && $lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) >= 1)
                                                <small class="label label-info"><i class="fa fa-clock-o"></i>
                                                    {{ isset($lead->updated_at) && $lead->updated_at->diffInMinutes(date('Y-m-d H:i:s')) }} minuto/i
                                                @else
                                                    <small class="label label-success"><i class="fa fa-clock-o"></i>
                                                        adesso
                                    @endif
                                @endif
                                </small>
                                <!-- General tools such as edit or delete-->
                                <!--
                                        <div class="tools">
                                            <i class="fa fa-edit"></i>
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    -->
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!-- /.box-body -->

                <div class="box-footer clearfix no-border">
                    <button onclick='window.location="{{ route('leads.create') }}"' type="button"
                        class="btn btn-default pull-right"><i class="fa fa-plus"></i> Aggiungi lead</button>
                    <button onclick='window.location="{{ route('leads.index') }}"' type="button"
                        class="btn btn-default pull-right"><i class="fa fa-list"></i> Vai alla lista dei lead</button>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Agenzie disponibili</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->

                    <ul class="todo-list">
                        @foreach ($dealers as $dealer)
                            <li>
                                <!-- todo text -->
                                <span class="text">{{ $dealer->name }}</span>
                                <!-- Emphasis label -->

                                @if ($dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) > 1440)
                                    <small class="label label-danger"><i class="fa fa-clock-o"></i>
                                        {{ (int) ($dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) / 1440) }}
                                        giorno/i
                                    @elseif ($dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) > 60)
                                        <small class="label label-warning"><i class="fa fa-clock-o"></i>
                                            {{ (int) ($dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) / 60) }}
                                            ora/e
                                        @elseif($dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) >= 1)
                                            <small class="label label-info"><i class="fa fa-clock-o"></i>
                                                {{ $dealer->created_at->diffInMinutes(date('Y-m-d H:i:s')) }} minuto/i
                                            @else
                                                <small class="label label-success"><i class="fa fa-clock-o"></i>
                                                    adesso
                                @endif
                                </small>
                                <!-- General tools such as edit or delete-->
                                <!--
                                        <div class="tools">
                                            <i class="fa fa-edit"></i>
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    -->
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!-- /.box-body -->

                <div class="box-footer clearfix no-border">
                    <button onclick='window.location="{{ route('dealers.index') }}"' type="button"
                        class="btn btn-default pull-right"><i class="fa fa-list"></i> Vai alla lista delle
                        agenzie</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function addPeriod(val) {
            document.location.href = window.location.pathname + "?state=" + $('.state').val() + "&period=" + val +
                "&agent=" + $('.agent').val();
        }

        function addState(val) {
            document.location.href = window.location.pathname + "?state=" + val + "&period=" + $('.period').val() +
                "&agent=" + $('.agent').val();
        }

        function addAgent(val) {
            document.location.href = window.location.pathname + "?state=" + $('.state').val() + "&period=" + $('.period')
                .val() + "&agent=" + val;
        }
    </script>
@endsection
