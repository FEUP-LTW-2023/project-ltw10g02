function searchTicket(input_id, div_name, option){
  const searchTicket = document.querySelector('#' + input_id)
  if (searchTicket) {
    searchTicket.addEventListener('input', async function() {
      const response = await fetch('../api/api_tickets_search.php?search=' + this.value + '&option=' + option)
      const tickets = await response.json()
      
      console.log(tickets)

      const ticketResumeSection = document.querySelector('#' + div_name)
      ticketResumeSection.innerHTML = ''

      for (const ticket of tickets) {
        /* Create elements */
        const article = document.createElement('article')

        const header = document.createElement('header')
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

        /* Append Child */
        header.appendChild(ticketH2)
        header.appendChild(ticketStatus)
        ticketH2.appendChild(anchorTicketPage)
        
        article.appendChild(header)
        article.appendChild(ticketDate)
        article.appendChild(ticketDescription)

        ticketResumeSection.appendChild(article)
      }
    })
  }
}

searchTicket('search_tickets', 'my_tickets', 1)
searchTicket('search_deparment_tickets', 'department_tickets', 2)