const searchTicket = document.querySelector('#search_tickets')
if (searchTicket) {
  searchTicket.addEventListener('input', async function() {
    const response = await fetch('../api/api_tickets_search.php?search=' + this.value)
    const tickets = await response.json()

    //console.log(tickets)
    console.log(JSON.stringify(tickets[0]));

    const tbody = document.querySelector('tbody')
    tbody.innerHTML = ''

    for (const ticket of tickets) {
      const tr = document.createElement('tr')

      const tdId = document.createElement('td')
      const tdSubject = document.createElement('td')
      const tdDescription = document.createElement('td')
      const tdStatus = document.createElement('td')

      tdId.textContent = ticket.id
      tdSubject.textContent = ticket.subject
      tdDescription.textContent = ticket.description
      tdStatus.textContent = ticket.status

      tr.appendChild(tdId)
      tr.appendChild(tdSubject)
      tr.appendChild(tdDescription)
      tr.appendChild(tdStatus)

      tbody.appendChild(tr)
    }
  })
}