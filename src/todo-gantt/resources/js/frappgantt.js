import Gantt from 'frappe-gantt';

// ガントチャートの初期化
var tasks = [
  {
    id: 'Task 1',
    name: 'タスク1',
    start: '2024-08-15',
    end: '2024-08-18',
    // progress: 20,
    user: '山本',
    user_id: 1,
    custom_class: 'user1-task' // ユーザー固有のクラス
  },
  {
    id: 'Task 2',
    name: 'タスク2',
    start: '2024-08-14',
    end: '2024-08-15',
    // progress: 20,
    user: '田中',
    user_id: 2,
    custom_class: 'user2-task' // 別のユーザー用のクラス
  },
  {
    id: 'Task 3',
    name: 'タスク3',
    start: '2024-08-15',
    end: '2024-08-017',
    // progress: 20,
    user: '田中',
    user_id: 2,
    custom_class: 'user2-task' // 別のユーザー用のクラス
  },
  {
    id: 'Task 4',
    name: 'タスク4',
    start: '2024-08-08',
    end: '2024-08-17',
    // progress: 20,
    user: '山田',
    user_id: 39,
    custom_class: 'user2-task' // 別のユーザー用のクラス
  },
  {
    id: 'Task 5',
    name: 'タスク5',
    start: '2024-08-12',
    end: '2024-08-14',
    // progress: 20,
    user: '山田',
    user_id: 39,
    custom_class: 'user2-task' // 別のユーザー用のクラス
  },
  {
    id: 'Task 6',
    name: 'タスク6',
    start: '2024-08-20',
    end: '2024-08-25',
    // progress: 20,
    user: '山田',
    user_id: 39,
    custom_class: 'user2-task' // 別のユーザー用のクラス
  },
  // 他のタスク...
];

// タスクをユーザーごとにグループ化する関数
function groupTasksByUser(tasks) {
  return tasks.reduce((groups, task) => {
    const user = task.user;
    if (!groups[user]) {
      groups[user] = [];
    }
    groups[user].push(task);
    return groups;
  }, {});
}

// 左側のユーザーリストを生成
function generateUserList() {
  var userList = document.getElementById('task-list');
  userList.innerHTML = ''; // リストをクリア

  const groupedTasks = groupTasksByUser(tasks);

  const userListHeader = document.createElement('div');
  userListHeader.style.height = '60px';
  userListHeader.style.display = 'flex';
  userListHeader.style.alignItems = 'center';
  userListHeader.style.justifyContent = 'center';
  userListHeader.style.borderBottom = '1px solid #ddd';
  userListHeader.style.backgroundColor = '#fff';
  userList.appendChild(userListHeader);

  for (const [user, userTasks] of Object.entries(groupedTasks)) {
    // ユーザー名を表示
    var userElement = document.createElement('div');
    userElement.textContent = user;
    userElement.style.padding = '10px';
    userElement.style.borderBottom = '1px solid #ddd';
    userElement.style.height = `${userTasks.length * 38}px`; // タスクの数に応じて高さを設定
    userElement.style.display = 'flex';
    userElement.style.alignItems = 'center';
    userElement.style.justifyContent = 'center';
    userElement.style.backgroundColor = '#fff';
    userList.appendChild(userElement);

  }
}

// ユーザーごとに色を割り当てる関数
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
  const index = user_id % colors.length; // user_idに基づいて色を選択
  return colors[index];
}

// タスクにカスタムクラスを割り当てる
tasks.forEach(task => {
  task.custom_class = `user-${task.user_id}-task`;
});

// CSSルールを動的に追加
tasks.forEach(task => {
  const color = assignColorToUser(task.user_id);
  const style = document.createElement('style');
  style.textContent = `.${task.custom_class} .bar { fill: ${color} !important; }`;
  document.head.appendChild(style);
});

// Ganttチャートの初期化
var gantt = new Gantt("#gantt", tasks);

function scroll_today() {
  if (!gantt.options.focus) {
    const oldest = gantt.get_oldest_starting_date().getTime();
    const t = new Date() - oldest;
    const newDate = new Date(gantt.gantt_start.getTime() - t);
    gantt.options.focus = newDate;
    gantt.gantt_start = newDate;
    gantt.set_scroll_position()
  } else {
    gantt.gantt_start = gantt.options.focus;
    gantt.set_scroll_position()
  }
}

generateUserList();
scroll_today();