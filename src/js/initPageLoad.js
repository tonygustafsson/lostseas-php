import snackbar from './components/snackbar';

if (window.isAdmin) {
    window.addEventListener('load', () => {
        snackbar({ text: 'Initial page load.', level: 'info' })
    });
}