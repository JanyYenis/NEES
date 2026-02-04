import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/main.css',
                'resources/css/datatable-gijac.css',
                'resources/css/datatables.css',
                'resources/css/producto.css',
                'resources/css/login.css',
                'resources/css/registro.css',
                'resources/css/admin.css',
                'resources/css/admin-cotizaciones.css',
                'resources/css/admin-pedidos.css',
                'resources/css/admin-productos.css',
                'resources/css/admin-usuarios.css',
                'resources/css/dashboard.css',
                'resources/css/categoria.css',

                'resources/js/app.js',
                'resources/js/jquery-validator.init.js',
                'resources/js/main.js',
                'resources/js/producto.js',
                'resources/js/login.js',
                'resources/js/registro.js',
                'resources/js/dashboard.js',

                'resources/js/categorias/principal.js',
                'resources/js/materiales/principal.js',
                'resources/js/productos/principal.js',

                'resources/js/admin-cotizaciones.js',
                'resources/js/admin-pedidos.js',
                'resources/js/admin-usuarios.js',
                'resources/js/categoria.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/img/*',
                    dest: 'img'
                }
            ]
        })
    ],
});
