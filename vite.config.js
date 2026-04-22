import { defineConfig } from 'vite';

export default defineConfig({
    root: './public_html',
    server: {
        host: true, // Allow access from network
        port: 5174
    }
});