import Gantt from 'frappe-gantt';
import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  withCredentials: true
});

async function fetchGanttData() {
  try {
    try {
      await axios.get('/sanctum/csrf-cookie', { withCredentials: true });
    } catch (error) {
      console.error('Error fetching CSRF cookie:', error);
      throw new Error('Failed to fetch CSRF cookie');
    }

    let token;
    try {
      const tokenResponse = await axios.get('/get-sanctum-token');
      token = tokenResponse.data.token;
    } catch (error) {
      console.error('Error fetching Sanctum token:', error);
      throw new Error('Failed to fetch Sanctum token');
    }

    api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    let ganttDatas;
    try {
      const response = await api.get('/gantt');
      ganttDatas = response.data;
    } catch (error) {
      console.error('Error fetching gantt data:', error);
      throw new Error('Failed to fetch gantt data');
    }

    if (ganttDatas.length === 0) {
      const ganttContainer = document.getElementById('gantt');
      const noTasksElement = document.createElement('div');
      noTasksElement.textContent = '進行中のタスクはありません';
      noTasksElement.style.padding = '20px';
      noTasksElement.style.fontSize = '18px';
      ganttContainer.appendChild(noTasksElement);
      return;
    }

    const tasks = extractTasks(ganttDatas);
    const gantt = new Gantt("#gantt", tasks);

    const groupedTasks = groupTasksByUser(tasks);
    generateUserList(groupedTasks);
    stylingBars(tasks);
    scroll_today(gantt);

  } catch (error) {
    console.error('Error in fetchGanttData:', error.message);
    const ganttContainer = document.getElementById('gantt');
    const errorElement = document.createElement('div');
    errorElement.textContent = 'データの取得に失敗しました。再読み込みしてください。';
    errorElement.style.color = 'red';
    ganttContainer.appendChild(errorElement);
  }
}

function extractTasks(ganttDatas) {
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);

  return ganttDatas.flatMap(project => {
    const projectTask = {
      id: `${project.id}`,
      name: project.name,
      start: project.start,
      end: project.end,
      user: project.user_name,
      user_id: project.user_id,
      progress: 0,
      dependencies: null,
      custom_class: `project-bar`
    };

    const projectTasks = project.tasks.map(task => {
      const startDate = task.start ? new Date(task.start) : today;
      const endDate = task.end ? new Date(task.end) : tomorrow;

      if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
        console.warn(`Invalid date for task ${task.id}. Skipping.`);
        return null;
      }

      return {
        id: task.id.toString(),
        name: task.name,
        start: startDate.toISOString().split('T')[0],
        end: endDate.toISOString().split('T')[0],
        user: project.user_name,
        user_id: project.user_id,
        custom_class: `user-${project.user_id}-task task-bar`,
        progress: 0,
      };
    }).filter(task => task !== null);

    return [projectTask, ...projectTasks];
  });
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
    const newDate = new Date(gantt.gantt_start.getTime() - t + (24 * 60 * 60 * 1000 * 2));
    gantt.options.focus = newDate;
    gantt.gantt_start = newDate;
    gantt.set_scroll_position();
  } else {
    gantt.gantt_start = gantt.options.focus;
    gantt.set_scroll_position();
  }
}

fetchGanttData();
