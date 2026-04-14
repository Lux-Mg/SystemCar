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

                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a data-toggle="tooltip" data-placement="bottom" title="List <?php echo $this->router->fetch_class(); ?>" href="<?php echo base_url($this->router->fetch_class()); ?>">List&nbsp;<?php echo $this->router->fetch_class(); ?></a>
                            </li>
                            <li data-toggle="tooltip" data-placement="bottom" class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><?php echo (isset($mensalista) ? '<i class="far fa-clock "></i>&nbsp;Last update:&nbsp;' .formata_data_banco_com_hora($mensalista->mensalista_data_alteracao) : ''); ?></div>
                    <div class="card-body">
                        <form class="forms-sample" name="form_core" method="POST">

                            <div class="form-group row">
                                <div class="col-md-3 mb-20">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="mensalista_nome" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_nome : set_value('mensalista_nome')); ?>">
                                    <?php echo form_error('mensalista_nome', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="mensalista_sobrenome" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_sobrenome : set_value('mensalista_sobrenome')); ?>">
                                    <?php echo form_error('mensalista_sobrenome', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-3 mb-20">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="mensalista_data_nascimento" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_data_nascimento : set_value('mensalista_data_nascimento')); ?>">
                                    <?php echo form_error('mensalista_data_nascimento', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 mb-20">
                                    <label>ID/Passport</label>
                                    <input type="text" class="form-control" name="mensalista_id_passport" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_id_passport : set_value('mensalista_id_passport')); ?>">
                                    <?php echo form_error('mensalista_id_passport', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-4 mb-20">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="mensalista_email" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_email : set_value('mensalista_email')); ?>">
                                    <?php echo form_error('mensalista_email', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-4 mb-20">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control sp_celphones" name="mensalista_telefone_movel" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_telefone_movel : set_value('mensalista_telefone_movel')); ?>">
                                    <?php echo form_error('mensalista_telefone_movel', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 mb-20">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="mensalista_endereco" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_endereco : set_value('mensalista_endereco')); ?>">
                                    <?php echo form_error('mensalista_endereco', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-1 mb-20">
                                    <label>Number</label>
                                    <input type="text" class="form-control" name="mensalista_numero_endereco" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_numero_endereco : set_value('mensalista_numero_endereco')); ?>">
                                    <?php echo form_error('mensalista_numero_endereco', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-4 mb-20">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="mensalista_cidade" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cidade : set_value('mensalista_cidade')); ?>">
                                    <?php echo form_error('mensalista_cidade', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-1 mb-20">
                                    <label>State</label>
                                    <input type="text" class="form-control uf" name="mensalista_estado" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_estado : set_value('mensalista_estado')); ?>">
                                    <?php echo form_error('mensalista_estado', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-2 mb-20">
                                    <label>Due Day</label>
                                    <input type="number" class="form-control" name="mensalista_dia_vencimento" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_dia_vencimento : set_value('mensalista_dia_vencimento')); ?>">
                                    <?php echo form_error('mensalista_dia_vencimento', '<div class="text-danger">', '</div>'); ?>
                                </div>

                                <div class="col-md-2 mb-20">
                                    <label>Active</label>
                                    <select class="form-control" name="mensalista_ativo">
                                        <?php if(isset($mensalista)): ?>
                                            <option value="0"<?php echo ($mensalista->mensalista_ativo == 0 ? 'selected' : '')?>>No</option>
                                            <option value="1"<?php echo ($mensalista->mensalista_ativo == 1 ? 'selected' : '')?>>Yes</option>
                                        <?php else: ?>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 mb-20">
                                    <label>Notes</label>
                                    <textarea class="form-control" name="mensalista_observacao"><?php echo (isset($mensalista) ? $mensalista->mensalista_observacao : set_value('mensalista_observacao')); ?></textarea>
                                    <?php echo form_error('mensalista_observacao', '<div class="text-danger">', '</div>'); ?>
                                </div>
                            </div>
                            <?php if (isset($mensalista)) : ?>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="mensalista_id" value="<?php echo $mensalista->mensalista_id; ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary mr-2">&nbsp;<i class="far fa-save"></i></button>
                            <a class="btn btn-info" href="<?php echo base_url($this->router->fetch_class()); ?>">&nbsp;<i class="fas fa-arrow-circle-right"></i></a>
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
            Copyright © <?php echo date('Y'); ?> System Car. All rights reserved.
        </span>
        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">
            Developed <i class="fas fa-code text-dark"></i>&nbsp;by:&nbsp;
            <a href="https://github.com/Lux-Mg" class="text-dark" target="_blank">Luis Mendoza</a>
        </span>
    </div>
</footer>

</div>


