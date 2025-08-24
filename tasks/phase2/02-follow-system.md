# 02. 팔로우 시스템 구현

## 🎯 목표
사용자 간 팔로우/언팔로우 기능을 구현하여 소셜 북마크 플랫폼의 기본 소셜 기능을 제공합니다.

## 📋 요구사항
### 기능적 요구사항
- 사용자 팔로우/언팔로우 기능
- 팔로워/팔로잉 목록 페이지
- 팔로우 상태 표시
- 팔로우 추천 시스템 (기본)
- 팔로우 활동 알림 (기본)
- 상호 팔로우 표시

### 기술적 요구사항
- 다대다 관계 (Many-to-Many) 구현
- 대용량 팔로우 데이터 처리 최적화
- 실시간 팔로우 상태 업데이트
- 팔로우 스팸 방지 (레이트 리미팅)

## 🛠️ 구현 사항

### Backend

#### 데이터베이스 설계
- [ ] 팔로우 관계 테이블 생성
  ```php
  // database/migrations/xxxx_create_follows_table.php
  Schema::create('follows', function (Blueprint $table) {
      $table->id();
      $table->foreignId('follower_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('following_id')->constrained('users')->cascadeOnDelete();
      $table->timestamp('created_at');
      
      $table->unique(['follower_id', 'following_id']);
      $table->index(['follower_id', 'created_at']);
      $table->index(['following_id', 'created_at']);
  });
  ```

#### 모델 관계 설정
- [ ] User 모델에 팔로우 관계 추가
  ```php
  // app/Models/User.php
  public function following()
  {
      return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
          ->withTimestamps(['created_at']);
  }
  
  public function followers()
  {
      return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
          ->withTimestamps(['created_at']);
  }
  
  // 헬퍼 메소드들
  public function isFollowing(User $user): bool
  public function toggleFollow(User $user): array
  public function getMutualFollowers(User $user): Collection
  ```

#### 컨트롤러 생성
- [ ] FollowController 생성
  ```php
  // app/Http/Controllers/FollowController.php
  - store(User $user) - 팔로우하기
  - destroy(User $user) - 언팔로우하기
  - followers(User $user) - 팔로워 목록
  - following(User $user) - 팔로잉 목록
  - suggestions() - 팔로우 추천 목록
  ```

#### 이벤트 및 리스너 생성
- [ ] 팔로우 이벤트 시스템
  ```php
  // app/Events/UserFollowed.php
  class UserFollowed {
      public User $follower;
      public User $following;
  }
  
  // app/Listeners/UpdateFollowCounts.php
  - 팔로워/팔로잉 수 업데이트
  
  // app/Listeners/SendFollowNotification.php
  - 팔로우 알림 전송 (나중에 구현)
  ```

#### 서비스 클래스 생성
- [ ] FollowService 생성
  ```php
  // app/Services/FollowService.php
  - followUser($follower, $following) - 팔로우 처리
  - unfollowUser($follower, $following) - 언팔로우 처리
  - getFollowSuggestions($user, $limit = 10) - 추천 사용자
  - getMutualFollows($user1, $user2) - 공통 팔로우 사용자
  - getFollowStats($user) - 팔로우 통계
  ```

#### API 엔드포인트 생성
- [ ] Follow API Routes
  ```php
  // routes/api.php
  Route::middleware('auth:sanctum')->group(function () {
      Route::post('/users/{user}/follow', [FollowController::class, 'store']);
      Route::delete('/users/{user}/follow', [FollowController::class, 'destroy']);
      Route::get('/users/{user}/followers', [FollowController::class, 'followers']);
      Route::get('/users/{user}/following', [FollowController::class, 'following']);
      Route::get('/follow/suggestions', [FollowController::class, 'suggestions']);
  });
  ```

### Frontend

#### 타입 정의
- [ ] 팔로우 관련 타입 추가
  ```typescript
  // resources/js/types/index.ts
  interface Follow {
    id: number;
    follower_id: number;
    following_id: number;
    created_at: string;
    follower?: User;
    following?: User;
  }
  
  interface FollowStats {
    followers_count: number;
    following_count: number;
    is_following: boolean;
    is_followed_by: boolean; // 상호 팔로우
  }
  
  interface FollowSuggestion {
    user: User;
    reason: string; // 추천 이유
    mutual_followers_count: number;
  }
  ```

#### 커스텀 훅 생성
- [ ] 팔로우 관련 훅들
  ```tsx
  // resources/js/hooks/useFollow.tsx
  - useFollow(userId) - 팔로우 상태 관리
  - useFollowMutation() - 팔로우/언팔로우 뮤테이션
  - useFollowList(userId, type) - 팔로워/팔로잉 목록
  - useFollowSuggestions() - 팔로우 추천
  ```

#### UI 컴포넌트 생성
- [ ] FollowButton 컴포넌트
  ```tsx
  // resources/js/components/FollowButton.tsx
  - 팔로우/언팔로우 토글 버튼
  - 로딩 상태 표시
  - 상호 팔로우 표시
  - 크기별 변형 (sm, md, lg)
  ```

- [ ] FollowList 컴포넌트
  ```tsx
  // resources/js/components/FollowList.tsx
  - 사용자 목록 표시
  - 무한 스크롤 지원
  - 팔로우 버튼 통합
  - 검색 기능
  ```

- [ ] FollowStats 컴포넌트
  ```tsx
  // resources/js/components/FollowStats.tsx
  - 팔로워/팔로잉 수 표시
  - 클릭 시 목록 페이지 이동
  - 애니메이션 카운터
  ```

- [ ] SuggestedUsers 컴포넌트
  ```tsx
  // resources/js/components/SuggestedUsers.tsx
  - 추천 사용자 카드 목록
  - 추천 이유 표시
  - 공통 팔로워 수 표시
  - 빠른 팔로우 버튼
  ```

#### 페이지 컴포넌트 생성
- [ ] 팔로워/팔로잉 목록 페이지
  ```tsx
  // resources/js/pages/profile/followers.tsx
  // resources/js/pages/profile/following.tsx
  - 사용자 목록 표시
  - 탭 네비게이션 (팔로워/팔로잉)
  - 검색 및 필터링
  - 상호 팔로우 표시
  ```

- [ ] 팔로우 추천 페이지
  ```tsx
  // resources/js/pages/discover/users.tsx
  - 추천 사용자 목록
  - 카테고리별 필터링
  - 관심사 기반 추천
  - 활발한 사용자 섹션
  ```

### 실시간 업데이트

#### Optimistic Updates
- [ ] 낙관적 업데이트 구현
  ```tsx
  // resources/js/hooks/useOptimisticFollow.tsx
  - 팔로우 버튼 클릭 시 즉시 UI 업데이트
  - API 실패 시 원복 처리
  - 네트워크 상태에 따른 처리
  ```

#### 상태 관리
- [ ] 팔로우 상태 전역 관리
  ```tsx
  // resources/js/stores/followStore.tsx
  - 팔로우 상태 캐싱
  - 여러 컴포넌트 간 상태 동기화
  - 메모리 효율적인 상태 관리
  ```

## 📁 파일 구조
```
app/
├── Events/
│   └── UserFollowed.php
├── Http/
│   └── Controllers/
│       └── FollowController.php
├── Listeners/
│   ├── UpdateFollowCounts.php
│   └── SendFollowNotification.php
├── Models/
│   └── User.php (확장)
└── Services/
    └── FollowService.php

database/
└── migrations/
    └── xxxx_create_follows_table.php

resources/js/
├── components/
│   ├── FollowButton.tsx
│   ├── FollowList.tsx
│   ├── FollowStats.tsx
│   └── SuggestedUsers.tsx
├── hooks/
│   ├── useFollow.tsx
│   └── useOptimisticFollow.tsx
├── pages/
│   ├── discover/
│   │   └── users.tsx
│   └── profile/
│       ├── followers.tsx
│       └── following.tsx
├── stores/
│   └── followStore.tsx
└── types/
    └── index.ts (확장)

routes/
├── api.php (팔로우 API)
└── web.php (팔로우 페이지)

tests/
├── Feature/
│   └── FollowSystemTest.php
└── Unit/
    ├── FollowServiceTest.php
    └── UserFollowTest.php
```

## ✅ 완료 기준
- [ ] 팔로우/언팔로우 버튼 정상 작동
- [ ] 팔로워/팔로잉 목록 페이지 구현
- [ ] 팔로우 수 실시간 업데이트
- [ ] 상호 팔로우 상태 표시
- [ ] 팔로우 추천 시스템 기본 구현
- [ ] 대용량 데이터 처리 (페이지네이션)
- [ ] 스팸 방지 레이트 리미팅
- [ ] 반응형 UI 구현
- [ ] 낙관적 업데이트 적용

## 🧪 테스트
### Backend 테스트
- [ ] 팔로우/언팔로우 API 테스트
- [ ] 중복 팔로우 방지 테스트
- [ ] 팔로우 수 업데이트 테스트
- [ ] 레이트 리미팅 테스트
- [ ] 대용량 데이터 성능 테스트

### Frontend 테스트
- [ ] 팔로우 버튼 상태 테스트
- [ ] 목록 페이지 렌더링 테스트
- [ ] 무한 스크롤 테스트
- [ ] 낙관적 업데이트 테스트

### E2E 테스트
- [ ] 팔로우 전체 플로우 테스트
- [ ] 팔로워 목록 조회 플로우
- [ ] 팔로우 추천 플로우

## 📚 참고자료
- [Laravel Many-to-Many Relationships](https://laravel.com/docs/11.x/eloquent-relationships#many-to-many)
- [Laravel Events](https://laravel.com/docs/11.x/events)
- [React Query Optimistic Updates](https://tanstack.com/query/latest/docs/react/guides/optimistic-updates)
- [Rate Limiting in Laravel](https://laravel.com/docs/11.x/rate-limiting)

---
**상태**: 📝 계획  
**예상 소요 시간**: 5-6일  
**담당자**: 백엔드/프론트엔드 개발팀  
**우선순위**: 매우 높음  
**의존성**: 01-user-profiles.md