<?php $__env->startSection('title', 'Productos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Productos</span>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">Agregar Producto</a>
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
                <th>SKU</th>
                <th>Nombre</th>
                <th>Precio Neto</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td><?php echo e($product->sku); ?></td>
                    <td class="d-flex align-items-center">
                        <?php
                            // Determine image URL: if imagen_url starts with http use it, otherwise treat as asset path
                            $imgUrl = $product->imagen_url;
                            if ($imgUrl && !preg_match('#^https?://#i', $imgUrl)) {
                                $imgUrl = asset($imgUrl);
                            }
                        ?>
                        <?php if(!empty($imgUrl)): ?>
                            <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($product->nombre); ?>" style="width:48px;height:48px;object-fit:cover;border-radius:4px;margin-right:8px;" />
                        <?php else: ?>
                            <div style="width:48px;height:48px;background:#f0f0f0;border-radius:4px;margin-right:8px;display:inline-block"></div>
                        <?php endif; ?>
                        <div><?php echo e($product->nombre); ?></div>
                    </td>
                    <td><?php echo e(number_format($product->precio_neto, 0, ',', '.')); ?></td>
                    <td><?php echo e(number_format($product->precio_venta, 0, ',', '.')); ?></td>
                    <?php
                        $stockClass = '';
                        if (isset($product->stock_bajo) && isset($product->stock_alto)) {
                            if ($product->stock_actual <= $product->stock_bajo) {
                                $stockClass = 'text-danger fw-bold';
                            } elseif ($product->stock_actual >= $product->stock_alto) {
                                $stockClass = 'text-success fw-bold';
                            }
                        }
                    ?>
                    <td class="<?php echo e($stockClass); ?>"><?php echo e($product->stock_actual); ?></td>
                    <td>
                        <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" style="display: inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
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
                <?php if($products->hasPages()): ?>
                    <nav aria-label="Paginación de productos">
                        <ul class="pagination justify-content-end mb-0">
                            <?php if($products->onFirstPage()): ?>
                                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                                    <span class="page-link">&laquo; Anterior</span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($products->previousPageUrl()); ?>" rel="prev" aria-label="Anterior">&laquo; Anterior</a>
                                </li>
                            <?php endif; ?>

                            <?php if($products->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($products->nextPageUrl()); ?>" rel="next" aria-label="Siguiente">Siguiente &raquo;</a>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ventasfix_project\resources\views/products/index.blade.php ENDPATH**/ ?>