<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Usuarios</span>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">Agregar Usuario</a>
        </h5>
        <div class="card-body">
            <form method="GET" class="mb-3 d-flex" action="<?php echo e(url()->current()); ?>">
                <div class="me-2">
                    <input type="text" name="id" value="<?php echo e(request('id')); ?>" class="form-control" placeholder="Filtrar por ID" />
                </div>
                <div>
                    <button class="btn btn-outline-primary" type="submit">Filtrar</button>
                </div>
            </form>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->id); ?></td>
                    <td><?php echo e($user->rut); ?></td>
                    <td><?php echo e($user->nombre); ?></td>
                    <td><?php echo e($user->apellido); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" style="display: inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php if($users->hasPages()): ?>
                    <nav aria-label="Paginación de usuarios">
                        <ul class="pagination justify-content-end mb-0">
                            
                            <?php if($users->onFirstPage()): ?>
                                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                                    <span class="page-link">&laquo; Anterior</span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($users->previousPageUrl()); ?>" rel="prev" aria-label="Anterior">&laquo; Anterior</a>
                                </li>
                            <?php endif; ?>

                            
                            <?php if($users->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($users->nextPageUrl()); ?>" rel="next" aria-label="Siguiente">Siguiente &raquo;</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
                                    <span class="page-link">Siguiente &raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ventasfix_project\resources\views/users/index.blade.php ENDPATH**/ ?>