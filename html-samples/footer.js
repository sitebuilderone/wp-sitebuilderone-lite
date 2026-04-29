document.addEventListener('click', function(e) {
  const link = e.target.closest('a');
  if (!link || !link.href) return;

  const href = link.href.toLowerCase();
  let eventData = null;

if (href.startsWith('tel:')) {
    eventData = {
      'event_name': 'contact_phone_click',
      'value': href.replace('tel:', '')
    };
  } 
  else if (href.startsWith('mailto:')) {
    eventData = {
      'event_name': 'contact_email_click',
      'value': href.replace('mailto:', '')
    };
  }

  if (eventData && typeof gtag === 'function') {
    gtag('event', eventData.event_name, {
      'contact_value': eventData.value,
      'link_text': link.innerText.trim(),
      'page_location': window.location.href
    });
  }
}, { passive: true });
