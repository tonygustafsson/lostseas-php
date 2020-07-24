describe('Bank', () => {
    beforeEach(() => {
        Cypress.Cookies.preserveOnce('ci_session');

        // Log in

        cy.request({
            method: 'POST',
            url: '/account/login',
            form: true,
            body: {
                login_email: 'tonygust@gmail.com',
                login_password: 'TestTest'
            }
          })
    });

    it('Can visit', () => {
        cy.visit('http://localhost:8080/bank');
    });

    it('Can save to account', () => {
        cy.visit('http://localhost:8080/bank');

        cy.get('#account-slider .noUi-handle')
            .click()
            .type('{rightarrow}')
            .type('{rightarrow}')
            .type('{rightarrow}')
            .type('{rightarrow}')
            .type('{rightarrow}');

        cy.get('#transfer_form button.primary').click();
    })
});
