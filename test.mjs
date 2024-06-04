import puppeteer from 'puppeteer';

async function test() {
    const browser = await puppeteer.launch();
    console.log('Puppeteer works!');
    await browser.close();
}

test();
