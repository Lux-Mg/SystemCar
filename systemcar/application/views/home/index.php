<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">
    <?php $this->load->view('layout/sidebar'); ?>
    <?php $currency = $this->config->item('currency_symbol'); ?>
    <div class="main-content">
        <div class="container-fluid">

            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="<?php echo $icone_view; ?> bg-blue"></i>
                            <div class="d-inline">
                                <h5><?php echo $titulo ?></h5>
                                <span><?php echo $sub_titulo ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notificaciones -->
            <?php if (isset($overdue_monthly_payments)): ?>
                <div class="alert alert-warning">
                    <?php echo $this->lang->line('overdue_monthly_payments'); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($precificacoes_inativas)): ?>
                <div class="alert alert-warning">
                    <?php echo $this->lang->line('inactive_pricings'); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($formas_inativas)): ?>
                <div class="alert alert-warning">
                    <?php echo $this->lang->line('inactive_payment_methods'); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($usuarios_inativos)): ?>
                <div class="alert alert-warning">
                    <?php echo $this->lang->line('inactive_users'); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($mensalistas_inativos)): ?>
                <div class="alert alert-warning">
                    <?php echo $this->lang->line('inactive_monthly_clients'); ?>
                </div>
            <?php endif; ?>

            <!-- Mensajes de sesión -->
            <?php if ($message = $this->session->flashdata('sucesso')): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-success alert-success text-white alert-dismissible fade show" role="alert">
                            <strong><i class="far fa-smile-wink"></i>&nbsp;<?php echo $message ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ik ik-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($message = $this->session->flashdata('info')): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-info alert-info text-white alert-dismissible fade show" role="alert">
                            <strong><i class="far fa-smile-wink"></i>&nbsp;<?php echo $message ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ik ik-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($message = $this->session->flashdata('error')): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-danger alert-danger text-white alert-dismissible fade show" role="alert">
                            <strong><i class="far fa-smile-wink"></i>&nbsp;<?php echo $message ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ik ik-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <div class="row">
                <div class="col-xl-3 col-md-12">
                    <div class="card proj-t-card">
                        <div class="card-body text-navy">
                            <div class="row align-items-center mb-30">
                                <div class="col-auto">
                                    <i class="fas fa-warehouse f-40"></i>
                                </div>
                                <div class="col pl-0">
                                    <h6 class="mb-5"><?php echo $this->lang->line('total_spots'); ?></h6>
                                    <h6 class="mb-5 font-weight-bold"><?php echo $numero_total_vagas->precificacao_numero_vagas; ?></h6>
                                </div>
                            </div>
                            <div class="row align-items-center text-center">
                                <div class="col">
                                    <span><?php echo $this->lang->line('free'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-navy text-white"><?php echo $numero_total_vagas->precificacao_numero_vagas - $total_estacionados_agora ; ?></h6>
                                </div>
                                <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                <div class="col">
                                    <span><?php echo $this->lang->line('occupied'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-navy text-white"><?php echo $total_estacionados_agora; ?></h6>
                                </div>
                            </div>
                            <h6 class="pt-badge bg-navy small">System Car</h6>
                        </div>
                    </div>
                </div>
                <!-- Mensais -->
                <div class="col-xl-3 col-md-12">
                    <div class="card proj-t-card">
                        <div class="card-body text-blue">
                            <div class="row align-items-center mb-30">
                                <div class="col-auto">
                                    <i class="fas fa-hand-holding-usd f-40"></i>
                                </div>
                                <div class="col pl-0">
                                    <h6 class="mb-5"><?php echo $this->lang->line('monthly'); ?></h6>
                                    <h6 class="mb-5 font-weight-bold"><?php echo $currency.'&nbsp;'.$total_mensalidades->total_mensalidades; ?></h6>
                                </div>
                            </div>
                            <div class="row align-items-center text-center">
                                <div class="col">
                                    <span><?php echo $this->lang->line('paid'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-blue text-white"><?php echo $total_mensalidades_pagas; ?></h6>
                                </div>
                                <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                <div class="col">
                                    <span><?php echo $this->lang->line('open'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-blue text-white"><?php echo $total_mensalidades_abertas; ?></h6>
                                </div>
                            </div>
                            <h6 class="pt-badge bg-blue small">System Car</h6>
                        </div>
                    </div>
                </div>
                <!-- Avulsos -->
                <div class="col-xl-3 col-md-12">
                    <div class="card proj-t-card">
                        <div class="card-body text-green">
                            <div class="row align-items-center mb-30">
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-alt f-40"></i>
                                </div>
                                <div class="col pl-0">
                                    <h6 class="mb-5"><?php echo $this->lang->line('single'); ?></h6>
                                    <h6 class="mb-5 font-weight-bold"><?php echo $currency.'&nbsp;'.$total_avulsos->total_avulsos; ?></h6>
                                </div>
                            </div>
                            <div class="row align-items-center text-center">
                                <div class="col">
                                    <span><?php echo $this->lang->line('paid'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-green text-white"><?php echo $total_avulsos_pagos; ?></h6>
                                </div>
                                <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                <div class="col">
                                    <span><?php echo $this->lang->line('open'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-green text-white"><?php echo $total_avulsos_abertos; ?></h6>
                                </div>
                            </div>
                            <h6 class="pt-badge bg-green small">System Car</h6>
                        </div>
                    </div>
                </div>
                <!-- Mensalistas -->
                <div class="col-xl-3 col-md-12">
                    <div class="card proj-t-card">
                        <div class="card-body text-purple">
                            <div class="row align-items-center mb-30">
                                <div class="col-auto">
                                    <i class="fas fa-users f-40"></i>
                                </div>
                                <div class="col pl-0">
                                    <h6 class="mb-5"><?php echo $this->lang->line('monthly_clients'); ?></h6>
                                    <h6 class="mb-5 font-weight-bold"><?php echo $total_mensalistas; ?></h6>
                                </div>
                            </div>
                            <div class="row align-items-center text-center">
                                <div class="col">
                                    <span><?php echo $this->lang->line('active'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-purple text-white"><?php echo $total_mensalistas_ativos; ?></h6>
                                </div>
                                <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                <div class="col">
                                    <span><?php echo $this->lang->line('inactive'); ?></span>
                                    <h6 class="mb-0 badge badge-pill badge-purple text-white"><?php echo $total_mensalistas_inativos; ?></h6>
                                </div>
                            </div>
                            <h6 class="pt-badge bg-purple small">System Car</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim estatistica -->

            <!-- Vagas e categorias da home -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-block text-center"><?php echo $this->lang->line('spot_status'); ?></div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Pequeno -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <p class="text-center text-uppercase small">
                                        <?php echo $this->lang->line('small_vehicle'); ?>
                                        <?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold">&nbsp;<i class="fas fa-ban"></i>&nbsp;'.$this->lang->line('deactivated').'</span>' : ''); ?>
                                    </p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-car fa-3x text-secondary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                                <?php
                                                $ocupadas = array();
                                                $placas = array();
                                                foreach ($vagas_ocupadas_pequeno as $vaga) {
                                                    $ocupadas [] = $vaga->estacionar_numero_vaga;
                                                    $placas [$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
                                                }
                                                ?>
                                                <?php for ($i = 1; $i <= $numero_vagas_pequeno->vagas; $i++) : ?>
                                                    <li class="list-inline-item">
                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="Placa:&nbsp;<?php echo $placas[$i] ?>" class="content">
                                                                        <i class="fas fa-car fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? 'bg-google' : 'bg-secondary'); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? $this->lang->line('deactivated') : $this->lang->line('free')); ?>" class="content">
                                                                        <div class="number"><?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '<i class="fas fa-ban text-white"></i>' : $i); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endfor;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Médio -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <p class="text-center text-uppercase small">
                                        <?php echo $this->lang->line('medium_vehicle'); ?>
                                        <?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold">&nbsp;<i class="fas fa-ban"></i>&nbsp;'.$this->lang->line('deactivated').'</span>' : ''); ?>
                                    </p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-truck-monster fa-3x text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                                <?php
                                                $ocupadas = array();
                                                $placas = array();
                                                foreach ($vagas_ocupadas_medio as $vaga) {
                                                    $ocupadas [] = $vaga->estacionar_numero_vaga;
                                                    $placas [$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
                                                }
                                                ?>
                                                <?php for ($i = 1; $i <= $numero_vagas_medio->vagas; $i++) : ?>
                                                    <li class="list-inline-item">
                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="Placa:&nbsp;<?php echo $placas[$i] ?>" class="content">
                                                                        <i class="fas fa-truck-monster fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? 'bg-google' : 'bg-primary'); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? $this->lang->line('deactivated') : $this->lang->line('free')); ?>" class="content">
                                                                        <div class="number"><?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '<i class="fas fa-ban text-white"></i>' : $i); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endfor;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Grande -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <p class="text-center text-uppercase small">
                                        <?php echo $this->lang->line('large_vehicle'); ?>
                                        <?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold">&nbsp;<i class="fas fa-ban"></i>&nbsp;'.$this->lang->line('deactivated').'</span>' : ''); ?>
                                    </p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-truck-moving fa-3x text-purple"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                                <?php
                                                $ocupadas = array();
                                                $placas = array();
                                                foreach ($vagas_ocupadas_grande as $vaga) {
                                                    $ocupadas [] = $vaga->estacionar_numero_vaga;
                                                    $placas [$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
                                                }
                                                ?>
                                                <?php for ($i = 1; $i <= $numero_vagas_grande->vagas; $i++) : ?>
                                                    <li class="list-inline-item">
                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="Placa:&nbsp;<?php echo $placas[$i] ?>" class="content">
                                                                        <i class="fas fa-truck-moving fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? 'bg-google' : 'bg-purple'); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? $this->lang->line('deactivated') : $this->lang->line('free')); ?>" class="content">
                                                                        <div class="number"><?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '<i class="fas fa-ban text-white"></i>' : $i); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endfor;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Moto -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <p class="text-center text-uppercase small">
                                        <?php echo $this->lang->line('motorcycle'); ?>
                                        <?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold">&nbsp;<i class="fas fa-ban"></i>&nbsp;'.$this->lang->line('deactivated').'</span>' : ''); ?>
                                    </p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-motorcycle fa-3x text-success"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                                <?php
                                                $ocupadas = array();
                                                $placas = array();
                                                foreach ($vagas_ocupadas_moto as $vaga) {
                                                    $ocupadas [] = $vaga->estacionar_numero_vaga;
                                                    $placas [$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;
                                                }
                                                ?>
                                                <?php for ($i = 1; $i <= $numero_vagas_moto->vagas; $i++) : ?>
                                                    <li class="list-inline-item">
                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="Placa:&nbsp;<?php echo $placas[$i] ?>" class="content">
                                                                        <i class="fas fa-motorcycle fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? 'bg-google' : 'bg-success'); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? $this->lang->line('deactivated') : $this->lang->line('free')); ?>" class="content">
                                                                        <div class="number"><?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '<i class="fas fa-ban text-white"></i>' : $i); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endfor;?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim vagas e categorias da home -->

        </div>
    </div>

    <footer class="footer">
        <div class="w-100 clearfix">
            <span class="text-center text-sm-left d-md-inline-block">
                Copyright © <?php echo date('Y'); ?> System Car. <?php echo $this->lang->line('all_rights_reserved'); ?>
            </span>
            <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">
                Developed by <i class="fas fa-code text-dark"></i>&nbsp;Luis Mendoza&nbsp;
                <a href="https://github.com/Lux-Mg" class="text-dark" target="_blank">github.com/Lux-Mg</a>
            </span>
        </div>
    </footer>
</div>


