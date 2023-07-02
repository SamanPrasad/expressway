import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/custom.css",
                "resources/js/app.js",
                "resources/js/users.js",
                "resources/js/buses.js",
                "resources/js/bus-routes.js",
                "resources/js/trips.js",
            ],
            refresh: true,
        }),
    ],
});
