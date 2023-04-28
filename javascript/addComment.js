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
    
    if (!response.ok) {
        const errorMessage = await response.text();
        alert('There was an error adding the comment: ${errorMessage}');
    }
    else{
      const formAddComment = document.querySelector('#add_comment')
    
      const article = document.createElement('article')
    
      const p = document.createElement('p')
    
      p.textContent = formData.get('comment')
    
      article.appendChild(p)
    
      formAddComment.insertAdjacentElement('beforebegin', article);
      
      // Remove the input value after add the comment
      document.querySelector('#add_comment > input[name = "comment"]').value = '';

      // Remove previous form submission listener
      this.removeEventListener('submit', handleSubmit)
    }
  }