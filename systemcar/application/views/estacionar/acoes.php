<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

<?php $this->load->view('layout/sidebar'); ?>

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
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li data-toggle="tooltip" data-placement="bottom" class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        
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

        <div class="row">
            <!-- Ticket print -->
            <div class="col-xl-4 col-md-12">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><?php echo $this->lang->line('ticket_print'); ?></h6>
                                <a target="_blank" class="btn bg-blue text-white" href="<?php echo base_url($this->router->fetch_class() . '/pdf/' . $estacionado->estacionar_id); ?>">
                                    <?php echo $this->lang->line('print'); ?>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-print bg-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- List tickets -->
            <div class="col-xl-4 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><?php echo $this->lang->line('list_tickets'); ?></h6>
                                <a class="btn bg-green text-white" href="<?php echo base_url($this->router->fetch_class()); ?>">
                                    <?php echo $this->lang->line('list'); ?>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list-ol bg-green"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New ticket -->
            <div class="col-xl-4 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><?php echo $this->lang->line('new_ticket'); ?></h6>
                                <a class="btn bg-yellow text-white" href="<?php echo base_url($this->router->fetch_class() . '/core/'); ?>">
                                    <?php echo $this->lang->line('new'); ?>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-plus bg-yellow"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End actions -->
        </div>
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