describe('Bank', () => {
    beforeEach(() => {
        Cypress.Cookies.preserveOnce('ci_session');

        // Log in
        cy.request('POST', '/account/login', {
            login_email: 'tonygust@gmail.com',
            login_password: 'TestTest'
        });
    });

    it('Can visit', () => {
        cy.visit('http://localhost:8080/bank');
    });
});
