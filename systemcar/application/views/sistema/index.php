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
                                <a data-toggle="tooltip" data-placement="left" title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <?php echo (isset($sistema) ? '<i class="far fa-clock "></i>&nbsp;'.$this->lang->line('last_update').':&nbsp;' . formata_data_banco_com_hora($sistema->sistema_data_alteracao) : ''); ?>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" name="form_index" method="POST">

                            <div class="form-group row">
                                <div class="col-md-6 mb-20">
                                    <label><?php echo $this->lang->line('corporate_name'); ?></label>
                                    <input type="text" class="form-control" name="sistema_razao_social" value="<?php echo (isset($sistema) ? $sistema->sistema_razao_social : set_value('sistema_razao_social')); ?>">
                                    <?php echo form_error('sistema_razao_social', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label><?php echo $this->lang->line('trade_name'); ?></label>
                                    <input type="text" class="form-control" name="sistema_nome_fantasia" value="<?php echo (isset($sistema) ? $sistema->sistema_nome_fantasia : set_value('sistema_nome_fantasia')); ?>">
                                    <?php echo form_error('sistema_nome_fantasia', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 mb-20">
                                    <label><?php echo $this->lang->line('mobile_phone'); ?></label>
                                    <input type="text" class="form-control sp_celphones" name="sistema_telefone_movel"
                                        placeholder="+51 94449399 or +7 9999999999"
                                        value="<?php echo (isset($sistema) ? $sistema->sistema_telefone_movel : set_value('sistema_telefone_movel')); ?>">
                                    <?php echo form_error('sistema_telefone_movel', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="col-md-5 mb-20">
                                    <label><?php echo $this->lang->line('address'); ?></label>
                                    <input type="text" class="form-control" name="sistema_endereco" value="<?php echo (isset($sistema) ? $sistema->sistema_endereco : set_value('sistema_endereco')); ?>">
                                    <?php echo form_error('sistema_endereco', '<div class="text-danger">', '</div>'); ?>
                                </div>
                                <div class="col-md-3 mb-20">
                                    <label><?php echo $this->lang->line('number'); ?></label>
                                    <input type="text" class="form-control" name="sistema_numero" value="<?php echo (isset($sistema) ? $sistema->sistema_numero : set_value('sistema_numero')); ?>">
                                    <?php echo form_error('sistema_numero', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 mb-20">
                                    <label><?php echo $this->lang->line('ticket_text'); ?></label>
                                    <textarea class="form-control" name="sistema_texto_ticket"><?php echo (isset($sistema) ? $sistema->sistema_texto_ticket : set_value('sistema_texto_ticket')); ?></textarea>
                                    <?php echo form_error('sistema_texto_ticket', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">&nbsp;<i class="far fa-save"></i></button>
                            <a class="btn btn-info" href="<?php echo base_url('/'); ?>">&nbsp;<i class="fas fa-arrow-circle-right"></i></a>
                        </form>
                    </div>
                </div>
            </div>
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


