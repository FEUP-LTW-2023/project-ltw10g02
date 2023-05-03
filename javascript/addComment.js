function addComment(){
    const formAddComment = document.querySelector('#add_comment')
    if (formAddComment) {
      formAddComment.addEventListener('submit', handleSubmit)
    }
  }
  
  async function handleSubmit(event) {
    event.preventDefault() // Prevents the page from reloading after submitting the form
  
    const formData = new FormData(this) // Get form data
  
    const response = await fetch('../api/api_tickets_add_comment.php', {
        method: 'POST',
        body: formData
      })

    const data = await response.json()
    
    if (!response.ok) {
        const errorMessage = await response.text()
        alert('There was an error adding the comment: ${errorMessage}')
    }
    else{
      /* Create elements */
      const article = document.createElement('article')
    
      const userNameComment = document.createElement('p')
      const createdTimeComment = document.createElement('p')
      const bodyComment = document.createElement('p')
      
      /* Create classes */
      article.classList.add("comments")

      /* Assigning data */
      userNameComment.textContent = data.user.name
      createdTimeComment.textContent = data.comment.updated_at
      bodyComment.textContent = data.comment.body
      
      /* Append Child */
      article.appendChild(userNameComment)
      article.appendChild(createdTimeComment)
      article.appendChild(bodyComment)

      /* Add the article before the comment area */
      const formAddComment = document.querySelector('#add_comment')
      formAddComment.insertAdjacentElement('beforebegin', article)
      
      /* Clean comment area */
      document.querySelector('#add_comment > input[name = "comment"]').value = ''

      /* Remove previous form submission listener */
      this.removeEventListener('submit', handleSubmit)
    }
  }