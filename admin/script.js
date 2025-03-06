const body = document.querySelector("body");
const darkLight = document.querySelector("#darkLight");
const sidebar = document.querySelector(".sidebar");
const submenuItems = document.querySelectorAll(".submenu_item");
const sidebarOpen = document.querySelector("#sidebarOpen");
const sidebarClose = document.querySelector(".collapse_sidebar");
const sidebarExpand = document.querySelector(".expand_sidebar");

// Sidebar Toggle
sidebarOpen.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

sidebarClose.addEventListener("click", () => {
  sidebar.classList.add("close", "hoverable");
});

sidebarExpand.addEventListener("click", () => {
  sidebar.classList.remove("close", "hoverable");
});

// Sidebar Hover Behavior
sidebar.addEventListener("mouseenter", () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.remove("close");
  }
});

sidebar.addEventListener("mouseleave", () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.add("close");
  }
});

// Dark/Light Mode Toggle
darkLight.addEventListener("click", () => {
  body.classList.toggle("dark");

  if (body.classList.contains("dark")) {
    darkLight.classList.replace("bx-sun", "bx-moon");
    localStorage.setItem("theme", "dark"); // Save preference
  } else {
    darkLight.classList.replace("bx-moon", "bx-sun");
    localStorage.setItem("theme", "light"); // Save preference
  }
});

// Load saved theme on page reload
const savedTheme = localStorage.getItem("theme");
if (savedTheme === "dark") {
  body.classList.add("dark");
  darkLight.classList.replace("bx-sun", "bx-moon");
} else {
  body.classList.remove("dark");
  darkLight.classList.replace("bx-moon", "bx-sun");
}

// Submenu Toggle (Only One Open at a Time)
submenuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    item.classList.toggle("show_submenu");

    submenuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show_submenu");
      }
    });
  });
});

// Adjust Sidebar Based on Screen Width
const adjustSidebar = () => {
  if (window.innerWidth < 768) {
    sidebar.classList.add("close");
  } else {
    sidebar.classList.remove("close");
  }
};

// Run on Load and Resize
adjustSidebar();
window.addEventListener("resize", adjustSidebar);

function editMessage(messageId) {
  let messageCell = document.getElementById("message_" + messageId);
  let currentText = messageCell.innerText;

  let formHtml = `<form method='POST' action='message_list.php'>
                      <input type='hidden' name='id' value='${messageId}'>
                      <input type='text' name='updatedMessage' value='${currentText}' required>
                      <button type='submit' name='update'>Save</button>
                      <button type='button' onclick='cancelEdit(${messageId}, "${currentText}")'>Cancel</button>
                  </form>`;

  messageCell.innerHTML = formHtml;
}

function cancelEdit(messageId, originalText) {
  document.getElementById("message_" + messageId).innerText = originalText;
}

