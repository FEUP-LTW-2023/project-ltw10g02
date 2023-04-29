const searchTicket = document.querySelector('#search_tickets')
if (searchTicket) {
  searchTicket.addEventListener('input', async function() {
    const response = await fetch('../api/api_tickets_search.php?search=' + this.value)
    const tickets = await response.json()

    console.log(tickets)
    console.log(JSON.stringify(tickets[0]));

    const ticketResumeSection = document.querySelector('#ticketResumeSection')
    ticketResumeSection.innerHTML = ''

    for (const ticket of tickets) {
      /* Create elements */
      const article = document.createElement('article')

      const anchorTicketPage = document.createElement('a')
      const ticketH2 = document.createElement('h2')
      const ticketStatus = document.createElement('p')
      const ticketDate = document.createElement('p')
      const ticketDescription = document.createElement('p')

      /* Create classes */
      article.classList.add("ticketResume");

      /* Assigning data */
      anchorTicketPage.href = "../pages/ticket.php?id=" + ticket.id
      anchorTicketPage.textContent = ticket.subject
      ticketStatus.textContent = ticket.status
      ticketDate.textContent = ticket.created_at
      ticketDescription.textContent = ticket.description

      ticketH2.appendChild(anchorTicketPage)
      article.appendChild(ticketH2)
      article.appendChild(ticketStatus)
      article.appendChild(ticketDate)
      article.appendChild(ticketDescription)

      ticketResumeSection.appendChild(article)
    }
  })
}