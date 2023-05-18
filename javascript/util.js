function redirectToPage(url) {
    window.location.href = url;
}

function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }