# データモデル詳細分析

## 1. ドメインモデル構成

### 1.1 選手管理（Racer）ドメイン
#### 主要テーブル
- racers: 選手基本情報
  - UCI/JCF両方の選手番号管理
  - 多言語対応（日本語/英語/カナ）
  - チーム所属情報
- name_change_logs: 選手名変更履歴
  - 名前変更の追跡
  - 変更理由の記録

#### 特徴と課題
- 選手情報の完全性確保
  - UCI/JCF番号の一意性管理
  - チーム名の統一管理
- 名前変更履歴の追跡
  - 過去の記録との整合性維持
  - 表記ゆれの防止

### 1.2 大会管理（Meet）ドメイン
#### 主要テーブル
- meets: 大会基本情報
  - シーズン管理
  - 地域グループ管理
- meet_groups: 地域グループ
- entry_groups: エントリーグループ
  - 同時スタートの管理
  - 周回距離設定
- entry_categories: エントリーカテゴリー
  - ポイント適用管理
  - 昇格判定管理

#### 特徴と課題
- 複雑な階層構造
  - meet → entry_group → entry_category → entry_racer
  - 各レベルでの設定の継承関係
- データの整合性管理
  - エントリー状態の管理
  - 記録との連携

### 1.3 カテゴリー管理（Category）ドメイン
#### 主要テーブル
- categories: カテゴリー定義
  - 年齢/性別条件
  - UCI/JCF要件
- category_groups: カテゴリーグループ
  - 昇格・降格ルール
- category_racers: 選手カテゴリー所属
  - 所属履歴管理
  - 昇格・降格記録

#### 特徴と課題
- 複雑なカテゴリールール
  - 年齢による自動分類
  - 実力による昇格・降格
  - UCI/JCF要件との整合
- データ構造の二重性
  - categories と races_categories の関係
  - 適用ルールの管理

### 1.4 ポイント管理（Point）ドメイン
#### 主要テーブル
- point_series: ポイントシリーズ定義
  - 計算ルール
  - 集計ルール
  - 有効期限管理
- point_series_groups: シリーズグループ
  - 優先度管理
- point_series_racers: 選手ポイント
  - ポイント履歴
  - ボーナスポイント

#### 特徴と課題
- 複雑な計算ロジック
  - 複数の計算ルール
  - 有効期限管理
  - 集計タイミング
- パフォーマンス問題
  - 集計処理の負荷
  - キャッシュ戦略

## 2. データフロー分析

### 2.1 選手登録フロー
1. 選手基本情報登録
2. カテゴリー自動判定
3. UCI/JCF番号の検証
4. チーム所属設定

### 2.2 大会運営フロー
1. 大会基本情報設定
2. エントリーグループ構成
3. カテゴリー設定
4. 選手エントリー
5. 記録管理
6. 結果確定

### 2.3 ランキング管理フロー
1. レース結果登録
2. ポイント計算
3. シリーズ集計
4. ランキング更新
5. 昇格・降格判定

## 3. データモデルの課題と解決策

### 3.1 構造的な課題
1. カテゴリー管理の複雑さ
   - 課題: categories と races_categories の二重構造
   - 解決策:
     - テーブル構造の統合
     - ルール管理の分離
     - 継承関係の明確化

2. エントリー構造の複雑さ
   - 課題: 深い階層構造による管理の複雑化
   - 解決策:
     - 階層構造の簡略化
     - 設定の継承ルールの明確化
     - キャッシュテーブルの導入

3. ポイント計算の複雑さ
   - 課題: 分散したロジックと高負荷の集計処理
   - 解決策:
     - 計算ロジックの集中化
     - バッチ処理の最適化
     - 集計結果のキャッシュ化

### 3.2 パフォーマンス最適化
1. インデックス戦略
   - 主要検索パターンの分析
   - 複合インデックスの設計
   - 不要インデックスの削除

2. クエリ最適化
   - JOINの最適化
   - サブクエリの見直し
   - クエリキャッシュの活用

3. キャッシュ戦略
   - アプリケーションレベルキャッシュ
   - 集計結果のキャッシュ
   - キャッシュ更新タイミングの管理

### 3.3 データ整合性
1. トランザクション管理
   - 複数テーブル更新の整合性
   - デッドロック対策
   - リトライ処理

2. 状態管理
   - ステータスフラグの一元管理
   - 更新フラグによる同期
   - 履歴管理の統一

## 4. 改善提案

### 4.1 短期的改善
1. インデックス最適化
2. キャッシュテーブル導入
3. クエリチューニング

### 4.2 中期的改善
1. カテゴリー管理の簡略化
2. ポイント計算ロジックの集中化
3. バッチ処理の最適化

### 4.3 長期的改善
1. データモデルの再構築
2. マイクロサービス化の検討
3. リアルタイム処理の強化
