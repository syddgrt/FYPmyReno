// captureChart.mjs

import puppeteer from 'puppeteer';
import fs from 'fs/promises';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

// Resolve the current file directory
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

async function captureChart(bladeFilePath, imagePath) {
    console.log('Starting captureChart function');

    try {
        console.log('Starting Puppeteer script...');

        const browser = await puppeteer.launch();
        const page = await browser.newPage();

        console.log('Setting HTML content...');

        // Read the content of the Blade file
        const bladeContent = await fs.readFile(bladeFilePath, 'utf-8');

        // Set the HTML content of the page to the Blade file content
        await page.setContent(bladeContent, { waitUntil: 'networkidle2' });

        console.log('Waiting for selectors...');

        // Wait for the chart elements to appear on the page
        await page.waitForSelector('#analyticsChart');
        await page.waitForSelector('#pieChart');

        console.log('Taking screenshots...');

        // Capture the chart elements
        const analyticsChart = await page.$('#analyticsChart');
        const pieChart = await page.$('#pieChart');

        // Screenshot the chart elements
        await analyticsChart.screenshot({ path: join(imagePath, 'chart-analytics.png') });
        await pieChart.screenshot({ path: join(imagePath, 'chart-pie.png') });

        console.log('Screenshots captured successfully.');

        await browser.close();
    } catch (error) {
        console.error('Error during Puppeteer execution:', error);
        throw error;
    }
}

// Usage: node captureChart.mjs <bladeFilePath> <imagePath>
const [bladeFilePath, imagePath] = process.argv.slice(2);
captureChart(bladeFilePath, imagePath).catch(error => {
    console.error('Error during Puppeteer execution:', error);
    process.exit(1);
});
