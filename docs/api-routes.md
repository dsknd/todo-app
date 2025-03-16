# API Routes Design

## プロジェクト関連

### プロジェクト
```
GET     /api/projects                  # プロジェクト一覧
POST    /api/projects                  # プロジェクト作成
GET     /api/projects/{id}            # プロジェクト詳細
PUT     /api/projects/{id}            # プロジェクト更新
DELETE  /api/projects/{id}            # プロジェクト削除
GET     /api/projects/{id}/statistics  # プロジェクト統計
```

### プロジェクトメンバー
```
GET     /api/projects/{id}/members             # メンバー一覧
POST    /api/projects/{id}/members             # メンバー追加
DELETE  /api/projects/{id}/members/{userId}    # メンバー削除
PUT     /api/projects/{id}/members/{userId}    # メンバー更新
```

### プロジェクトロール
```
GET     /api/projects/{id}/roles               # ロール一覧
POST    /api/projects/{id}/roles               # ロール作成
GET     /api/projects/{id}/roles/{roleId}      # ロール詳細
PUT     /api/projects/{id}/roles/{roleId}      # ロール更新
DELETE  /api/projects/{id}/roles/{roleId}      # ロール削除
POST    /api/projects/{id}/roles/{roleId}/permissions  # 権限割り当て
```

### プロジェクト招待
```
GET     /api/projects/{id}/invitations         # 招待一覧
POST    /api/projects/{id}/invitations         # 招待作成
GET     /api/projects/{id}/invitations/{invId} # 招待詳細
PUT     /api/projects/{id}/invitations/{invId} # 招待更新
DELETE  /api/projects/{id}/invitations/{invId} # 招待削除
POST    /api/projects/{id}/invitations/{invId}/accept  # 招待受諾
POST    /api/projects/{id}/invitations/{invId}/decline # 招待拒否
```

## タスク関連

### タスク
```
GET     /api/projects/{id}/tasks               # タスク一覧
POST    /api/projects/{id}/tasks               # タスク作成
GET     /api/projects/{id}/tasks/{taskId}      # タスク詳細
PUT     /api/projects/{id}/tasks/{taskId}      # タスク更新
DELETE  /api/projects/{id}/tasks/{taskId}      # タスク削除
GET     /api/projects/{id}/tasks/{taskId}/statistics  # タスク統計
```

### タスク依存関係
```
GET     /api/tasks/{id}/dependencies          # 依存関係一覧
POST    /api/tasks/{id}/dependencies          # 依存関係追加
DELETE  /api/tasks/{id}/dependencies/{depId}  # 依存関係削除
```

### タスクコメント
```
GET     /api/tasks/{id}/comments              # コメント一覧
POST    /api/tasks/{id}/comments              # コメント作成
PUT     /api/tasks/{id}/comments/{commentId}  # コメント更新
DELETE  /api/tasks/{id}/comments/{commentId}  # コメント削除
```

### タスク割り当て
```
GET     /api/tasks/{id}/assignments           # 割り当て一覧
POST    /api/tasks/{id}/assignments           # 割り当て作成
DELETE  /api/tasks/{id}/assignments/{userId}  # 割り当て削除
```

## マイルストーン関連

### マイルストーン
```
GET     /api/projects/{id}/milestones                # マイルストーン一覧
POST    /api/projects/{id}/milestones                # マイルストーン作成
GET     /api/projects/{id}/milestones/{milestoneId}  # マイルストーン詳細
PUT     /api/projects/{id}/milestones/{milestoneId}  # マイルストーン更新
DELETE  /api/projects/{id}/milestones/{milestoneId}  # マイルストーン削除
```

### マイルストーンタスク
```
GET     /api/milestones/{id}/tasks           # タスク一覧
POST    /api/milestones/{id}/tasks           # タスク追加
DELETE  /api/milestones/{id}/tasks/{taskId}  # タスク削除
PUT     /api/milestones/{id}/tasks/order     # タスク順序更新
```

## タグ関連

### プロジェクトタグ
```
GET     /api/projects/{id}/tags              # タグ一覧
POST    /api/projects/{id}/tags              # タグ作成
PUT     /api/projects/{id}/tags/{tagId}      # タグ更新
DELETE  /api/projects/{id}/tags/{tagId}      # タグ削除
```

### 個人タグ
```
GET     /api/users/{id}/tags                 # タグ一覧
POST    /api/users/{id}/tags                 # タグ作成
PUT     /api/users/{id}/tags/{tagId}         # タグ更新
DELETE  /api/users/{id}/tags/{tagId}         # タグ削除
```

### タグ割り当て
```
POST    /api/tags/{id}/assignments           # タグ割り当て
DELETE  /api/tags/{id}/assignments/{targetId} # タグ割り当て解除
```

## その他

### ユーザー
```
GET     /api/users                    # ユーザー一覧
GET     /api/users/{id}              # ユーザー詳細
PUT     /api/users/{id}              # ユーザー更新
GET     /api/users/{id}/projects     # 参加プロジェクト一覧
GET     /api/users/{id}/tasks        # 担当タスク一覧
```

### システム設定
```
GET     /api/settings/categories      # カテゴリー一覧
GET     /api/settings/statuses        # ステータス一覧
GET     /api/settings/priorities      # 優先度一覧
GET     /api/settings/permissions     # 権限一覧
```

### 認証
```
POST    /api/auth/login              # ログイン
POST    /api/auth/logout             # ログアウト
POST    /api/auth/refresh            # トークンリフレッシュ
GET     /api/auth/user               # 認証ユーザー情報