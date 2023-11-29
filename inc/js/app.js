function showEdit(){
    document.getElementById("div_profile_edit").style.display = "none"
    document.getElementById("div_profile_save_cancel").style.display = "inline"
    document.getElementById("text_profile_name").removeAttribute('readonly');
    document.getElementById("text_profile_email").removeAttribute('readonly');
}

const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')

if (toastTrigger) {
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
  toastTrigger.addEventListener('click', () => {
    toastBootstrap.show()
  })
}