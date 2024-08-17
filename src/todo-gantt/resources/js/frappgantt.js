import Gantt from 'frappe-gantt';
import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  withCredentials: true
});

async function fetchGanttData() {
  try {
    await axios.get('/sanctum/csrf-cookie', { withCredentials: true });

    const tokenResponse = await axios.get('/get-sanctum-token');
    const token = tokenResponse.data.token;

    api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    const response = await api.get('/gantt');
    const taskDatas = response.data;
    const tasks = extractTasks(taskDatas);

    const gantt = new Gantt("#gantt", tasks);

    const groupedTasks = groupTasksByUser(tasks);
    generateUserList(groupedTasks);
    stylingBars(tasks);
    scroll_today(gantt);

  } catch (error) {
    if (error.response) {
      console.error('Error fetching gantt data:', error.response.status, error.response.data);
    } else if (error.request) {
      console.error('No response received:', error.request);
    } else {
      console.error('Error setting up request:', error.message);
    }
  }
}

function extractTasks(taskDatas) {
  let tasks = [];
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);

  taskDatas.forEach(project => {
    project.tasks.forEach(task => {
      const startDate = task.start_date ? new Date(task.start_date) : today;
      const endDate = task.end_date ? new Date(task.end_date) : tomorrow;

      if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
        console.warn(`Invalid date for task ${task.id}. Skipping.`);
        return;
      }

      tasks.push({
        id: task.id.toString(),
        name: task.name,
        start: startDate.toISOString().split('T')[0],
        end: endDate.toISOString().split('T')[0],
        user: project.user_name,
        user_id: project.user_id,
        custom_class: `user-${project.user_id}-task`,
        progress: 0
      });
    });
  });
  return tasks;
}

function groupTasksByUser(tasks) {
  return tasks.reduce((groups, task) => {
    if (!groups[task.user]) {
      groups[task.user] = [];
    }
    groups[task.user].push(task);
    return groups;
  }, {});
}

function generateUserList(groupedTasks) {
  const userList = document.querySelector('.task-list');
  userList.innerHTML = '';

  const userListHeader = document.createElement('div');
  userListHeader.style.height = '60px';
  userListHeader.style.display = 'flex';
  userListHeader.style.alignItems = 'center';
  userListHeader.style.justifyContent = 'center';
  userListHeader.style.borderBottom = '1px solid #ddd';
  userListHeader.style.backgroundColor = '#fff';
  userList.appendChild(userListHeader);

  for (const [user, userTasks] of Object.entries(groupedTasks)) {
    const userElement = document.createElement('div');
    userElement.textContent = user;
    userElement.style.borderBottom = '1px solid #ddd';
    userElement.style.height = `${userTasks.length * 38}px`;
    userElement.style.paddingLeft = '10px';
    userElement.style.display = 'flex';
    userElement.style.alignItems = 'center';
    userElement.style.justifyContent = 'flex-start';
    userElement.style.backgroundColor = '#fff';
    userElement.style.overflow = 'auto';
    userElement.style.textWrap = 'nowrap';
    userElement.classList.add('scroll-box');
    userList.appendChild(userElement);
  }
}

function assignColorToUser(user_id) {
  const colors = [
    '#7F7F7F', '#7F7F00', '#7F007F', '#007F7F', '#7F3F3F',
    '#3F7F3F', '#3F3F7F', '#7F5F00', '#007F5F', '#5F007F',
    '#7F007F', '#007F7F', '#7F7F3F', '#3F7F7F', '#7F3F7F',
    '#7F7F5F', '#5F7F7F', '#7F5F7F', '#7F7F7F', '#7F7F00',
    '#7F007F', '#007F7F', '#7F3F3F', '#3F7F3F', '#3F3F7F',
    '#7F5F00', '#007F5F', '#5F007F', '#7F007F', '#007F7F',
    '#7F7F3F', '#3F7F7F', '#7F3F7F', '#7F7F5F', '#5F7F7F',
    '#7F5F7F', '#7F7F7F', '#7F7F00', '#7F007F', '#007F7F',
    '#7F3F3F', '#3F7F3F', '#3F3F7F', '#7F5F00', '#007F5F',
    '#5F007F', '#7F007F', '#007F7F', '#7F7F3F', '#3F7F7F'
  ];
  return colors[user_id % colors.length];
}

function stylingBars(tasks) {
  const styleElement = document.createElement('style');
  document.head.appendChild(styleElement);
  const styleSheet = styleElement.sheet;

  tasks.forEach(task => {
    const color = assignColorToUser(task.user_id);
    const cssRule = `.user-${task.user_id}-task .bar { fill: ${color} !important; }`;
    styleSheet.insertRule(cssRule, styleSheet.cssRules.length);
  });
}

function scroll_today(gantt) {
  if (!gantt.options.focus) {
    const oldest = gantt.get_oldest_starting_date().getTime();
    const t = new Date() - oldest;
    const newDate = new Date(gantt.gantt_start.getTime() - t);
    gantt.options.focus = newDate;
    gantt.gantt_start = newDate;
    gantt.set_scroll_position();
  } else {
    gantt.gantt_start = gantt.options.focus;
    gantt.set_scroll_position();
  }
}

fetchGanttData();
