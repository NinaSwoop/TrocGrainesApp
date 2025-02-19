import { test, expect } from '@playwright/test';

test('go to connexion form', async ({ page }) => {
  await page.goto('http://localhost:5173');

  await page.getByRole('button', { name: 'user icon Connexion' }).click();

  await page.waitForURL('http://localhost:5173/login');

  await expect(page).toHaveURL('http://localhost:5173/login');

});

test('fill connexion form', async ({ page }) => {
  await page.goto('http://localhost:5173/login');

  await page
      .getByPlaceholder('email@email.com')
      .fill('suzanne@gmail.com');

  await page
      .getByPlaceholder('********')
      .fill('MonMotDePasse1234!');

  await page
      .getByRole('button', { name: 'Connexion', exact: true })
      .click();

  await page.waitForURL('http://localhost:5173');

  await expect(page).toHaveURL('http://localhost:5173');

  expect(page.getByText('Suzanne').nth(1));

});


