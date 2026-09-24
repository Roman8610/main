# Сценарии управления через AI

Этот документ описывает первый контракт между MCP-сервером и приложением Yii 2.
MCP-сервер не должен обращаться к базе данных напрямую для изменения данных. Для
изменяющих операций он вызывает существующие сервисы модуля `Qm`.

## Приоритеты

| Приоритет | MCP-команда | Назначение | Состояние |
| --- | --- | --- | --- |
| P0 | `list_meetings` | Найти совещания | Read-only MVP |
| P0 | `get_meeting_questions` | Получить вопросы совещания | Read-only MVP |
| P0 | `get_question` | Получить один вопрос | Read-only MVP |
| P0 | `get_question_comments` | Получить комментарии к вопросу | Read-only MVP |
| P1 | `create_question_draft` | Создать черновик вопроса | После MVP |
| P1 | `submit_question_for_moderation` | Отправить вопрос на модерацию | После исправления проверки прав |
| P1 | `create_comment` | Добавить комментарий к опубликованному вопросу | После MVP |
| P1 | `publish_question` | Опубликовать вопрос | После MVP, с подтверждением |
| P1 | `reject_question` | Отклонить вопрос с причиной | После MVP, с подтверждением |

## Контракт команд

### `list_meetings`

| Поле | Значение |
| --- | --- |
| Назначение | Поиск и список совещаний |
| Yii-источник | `app\\modules\\Qm\\models\\Meeting` |
| Параметры | `search` (необязательно), `date_from` (необязательно), `date_to` (необязательно), `limit` |
| Права | Только авторизованный пользователь; список должен учитывать доступ пользователя |
| Результат | Массив `id`, `name` и дат совещаний |
| Изменяет данные | Нет |

> В текущем коде отдельного read-only-сервиса для списка совещаний нет. Его нужно
> сделать в MCP-адаптере или вынести в небольшой Yii-сервис до подключения команды.

### `get_meeting_questions`

| Поле | Значение |
| --- | --- |
| Назначение | Получить вопросы выбранного совещания |
| Yii-источник | `MeetingQuestion::findByQuestions($meetingId)` |
| Параметры | `meeting_id`, `status` (необязательно), `limit` |
| Права | Проверить доступ пользователя к каждому вопросу через `MeetingQuestionAccessService::canView()` |
| Результат | Массив вопросов с `id`, `name`, `status`, `created_by`, `deadline` |
| Изменяет данные | Нет |

### `get_question`

| Поле | Значение |
| --- | --- |
| Назначение | Получить подробности вопроса |
| Yii-источник | `MeetingQuestion::findOne($questionId)` |
| Параметры | `question_id` |
| Права | `MeetingQuestionAccessService::canView($question_id, $user_id)` |
| Результат | Текст вопроса, предлагаемое решение, статус, совещание, автор, адресаты и срок |
| Изменяет данные | Нет |

### `get_question_comments`

| Поле | Значение |
| --- | --- |
| Назначение | Получить комментарии и ответы к вопросу |
| Yii-источник | Связь `MeetingQuestion::getCommentQuestions()` |
| Параметры | `question_id` |
| Права | Сначала проверить `canView()`, затем вернуть комментарии только доступного вопроса |
| Результат | `id`, `text`, `parent_id`, `created_at` и автор комментария |
| Изменяет данные | Нет |

### `create_question_draft`

| Поле | Значение |
| --- | --- |
| Назначение | Создать вопрос в статусе `draft` |
| Yii-сервис | `CreateDraftMeetingQuestionService::run(MeetingQuestionForm)` |
| Параметры | `meeting_id`, `name`, `question_text`, `recipients`, `decision` (необязательно), `comment` (необязательно), `deadline` (необязательно) |
| Права | `MeetingQuestionAccessService::canCreate($meeting_id, $user_id)` |
| Результат | `question_id`, статус `draft` и основные поля созданного вопроса |
| Изменяет данные | Да |
| Подтверждение | Да, перед созданием |

### `submit_question_for_moderation`

| Поле | Значение |
| --- | --- |
| Назначение | Перевести вопрос в статус `pending` |
| Yii-сервис | `SubmitForModerationService::run(...)` |
| Параметры | `question_id` |
| Права | Автор вопроса; проверка должна явно вызываться через `canSubmitForModeration()` |
| Результат | `question_id` и статус `pending` |
| Изменяет данные | Да |
| Подтверждение | Да |

### `create_comment`

| Поле | Значение |
| --- | --- |
| Назначение | Добавить комментарий или ответ на комментарий |
| Yii-сервис | `CreateCommentService::run(CommentForm)` |
| Параметры | `question_id`, `text`, `parent_id` (необязательно) |
| Права | `MeetingQuestionAccessService::canCreateCommentToQuestion()`; вопрос должен быть опубликован |
| Результат | `comment_id`, `question_id`, `text`, `parent_id`, `created_at` |
| Изменяет данные | Да |
| Подтверждение | Да |

### `publish_question`

| Поле | Значение |
| --- | --- |
| Назначение | Опубликовать вопрос после модерации |
| Yii-сервис | `PublishMeetingQuestionService::run(PublishedMeetingQuestionModerationForm)` |
| Параметры | `question_id`, `departments`, `directions` |
| Права | Модератор/руководитель через `canMakeModeration()` |
| Результат | `question_id` и статус `published` |
| Изменяет данные | Да |
| Подтверждение | Обязательно |

### `reject_question`

| Поле | Значение |
| --- | --- |
| Назначение | Отклонить вопрос с причиной |
| Yii-сервис | `RejectMeetingQuestionService::run(RejectMeetingQuestionModerationForm)` |
| Параметры | `question_id`, `comment_moderator` |
| Права | Модератор/руководитель через `canMakeModeration()` |
| Результат | `question_id`, статус `rejected` и причина |
| Изменяет данные | Да |
| Подтверждение | Обязательно |

## Что нужно исправить до подключения команд

1. `SubmitForModerationService` переводит вопрос в `pending`, но сам не вызывает
   `canSubmitForModeration()`. MCP-адаптер не должен компенсировать это обходным
   кодом: проверку нужно добавить в сервис.
2. В `MeetingQuestionAccessService` методы `isAdmin()` и `isBoss()` используют
   фиксированные ID пользователей. Для реального MCP-доступа эти роли должны
   приходить из действующей системы ролей или базы данных.
3. Методы `canCreateCommentToComment()`, `canUpdateComment()` и
   `canDeleteComment()` сейчас всегда возвращают `true`. Команды изменения
   комментариев нельзя публиковать через MCP до исправления этих проверок.
4. Для всех MCP-команд нужен контекст пользователя: `user_id`, роли и аудит
   вызова. Нельзя использовать одного администратора для всех запросов AI.

## Определение MVP

MVP состоит только из четырёх команд P0:

```text
list_meetings
get_meeting_questions
get_question
get_question_comments
```

Они не изменяют данные. Сначала нужно проверить фильтрацию по правам и корректность
ответов, затем подключать команды P1 с явным подтверждением пользователя.