# 01. 사용자 프로필 시스템 확장

## 🎯 목표
사용자 프로필 페이지를 소셜 기능에 맞게 확장하고, 다른 사용자의 프로필 및 북마크를 조회할 수 있는 기능을 구현합니다.

## 📋 요구사항
### 기능적 요구사항
- 공개 사용자 프로필 페이지
- 사용자 검색 기능
- 프로필 통계 정보 표시
- 사용자별 공개 북마크 목록
- 프로필 공유 기능
- 사용자 활동 피드 (기본)

### 기술적 요구사항
- SEO 친화적 프로필 URL
- 공개/비공개 설정에 따른 접근 제어
- 사용자명 기반 라우팅
- 소셜 메타 태그 지원

## 🛠️ 구현 사항

### Backend

#### 라우팅 시스템 개선
- [ ] 사용자명 기반 라우팅
  ```php
  // routes/web.php
  Route::get('/@{username}', [PublicProfileController::class, 'show'])
      ->name('profile.public');
  Route::get('/@{username}/bookmarks', [PublicProfileController::class, 'bookmarks'])
      ->name('profile.bookmarks');
  Route::get('/@{username}/categories', [PublicProfileController::class, 'categories'])
      ->name('profile.categories');
  ```

#### 컨트롤러 생성
- [ ] PublicProfileController 생성
  ```php
  // app/Http/Controllers/PublicProfileController.php
  - show($username) - 공개 프로필 보기
  - bookmarks($username) - 사용자의 공개 북마크
  - categories($username) - 사용자의 공개 카테고리
  ```

- [ ] UserSearchController 생성
  ```php
  // app/Http/Controllers/UserSearchController.php
  - index() - 사용자 검색 페이지
  - search(Request $request) - 사용자 검색 API
  ```

#### 모델 확장
- [ ] User 모델에 추가 메소드
  ```php
  // app/Models/User.php
  - getRouteKeyName() - username으로 라우트 바인딩
  - getPublicBookmarks() - 공개 북마크 조회
  - getPublicCategories() - 공개 카테고리 조회
  - getActivityStats() - 활동 통계 정보
  - isProfilePublic() - 프로필 공개 여부
  ```

#### 서비스 클래스 생성
- [ ] ProfileService 생성
  ```php
  // app/Services/ProfileService.php
  - getProfileStats($user) - 프로필 통계 데이터
  - getRecentActivity($user) - 최근 활동 내역
  - generateShareableProfile($user) - 공유용 프로필 데이터
  ```

- [ ] UserSearchService 생성
  ```php
  // app/Services/UserSearchService.php
  - searchUsers($query, $filters) - 사용자 검색
  - getSuggestedUsers($user) - 추천 사용자 목록
  ```

### Frontend

#### 타입 정의 확장
- [ ] 프로필 관련 타입 추가
  ```typescript
  // resources/js/types/index.ts
  interface UserProfile {
    user: User;
    stats: {
      total_bookmarks: number;
      public_bookmarks: number;
      categories_count: number;
      followers_count: number;
      following_count: number;
    };
    recent_activity: Activity[];
    is_following?: boolean;
  }
  
  interface Activity {
    id: number;
    type: 'bookmark_created' | 'category_created';
    data: any;
    created_at: string;
  }
  ```

#### 페이지 컴포넌트 생성
- [ ] 공개 프로필 페이지
  ```tsx
  // resources/js/pages/profile/public.tsx
  - 프로필 헤더 (아바타, 이름, 바이오)
  - 통계 카드들
  - 팔로우 버튼
  - 최근 북마크 목록
  - 활동 피드
  ```

- [ ] 사용자 검색 페이지
  ```tsx
  // resources/js/pages/users/search.tsx
  - 검색 입력 폼
  - 사용자 검색 결과 목록
  - 필터링 옵션
  - 추천 사용자 섹션
  ```

- [ ] 사용자별 북마크 목록 페이지
  ```tsx
  // resources/js/pages/profile/bookmarks.tsx
  - 사용자 프로필 요약
  - 공개 북마크 목록
  - 카테고리별 필터링
  ```

#### UI 컴포넌트 생성
- [ ] ProfileHeader 컴포넌트
  ```tsx
  // resources/js/components/ProfileHeader.tsx
  - 아바타 및 기본 정보
  - 팔로우/언팔로우 버튼
  - 프로필 공유 버튼
  - 통계 표시
  ```

- [ ] UserCard 컴포넌트
  ```tsx
  // resources/js/components/UserCard.tsx
  - 사용자 아바타 및 이름
  - 간단한 통계
  - 팔로우 상태 표시
  - 프로필 링크
  ```

- [ ] ActivityFeed 컴포넌트
  ```tsx
  // resources/js/components/ActivityFeed.tsx
  - 시간순 활동 목록
  - 활동 타입별 아이콘
  - 무한 스크롤 지원
  ```

- [ ] StatsCard 컴포넌트
  ```tsx
  // resources/js/components/StatsCard.tsx
  - 통계 수치 표시
  - 아이콘 및 설명
  - 클릭 가능한 링크
  ```

### SEO 및 공유 기능

#### 메타 태그 최적화
- [ ] 동적 메타 태그 생성
  ```php
  // app/Http/Controllers/PublicProfileController.php
  - 사용자별 title 및 description
  - Open Graph 태그
  - Twitter Card 태그
  - 프로필 이미지 og:image
  ```

#### 공유 기능 구현
- [ ] 프로필 공유 컴포넌트
  ```tsx
  // resources/js/components/ShareProfile.tsx
  - 링크 복사 기능
  - 소셜 미디어 공유 링크
  - QR 코드 생성 (선택적)
  ```

## 📁 파일 구조
```
app/
├── Http/
│   └── Controllers/
│       ├── PublicProfileController.php
│       └── UserSearchController.php
├── Models/
│   └── User.php (확장)
└── Services/
    ├── ProfileService.php
    └── UserSearchService.php

resources/js/
├── components/
│   ├── ProfileHeader.tsx
│   ├── UserCard.tsx
│   ├── ActivityFeed.tsx
│   ├── StatsCard.tsx
│   └── ShareProfile.tsx
├── pages/
│   ├── profile/
│   │   ├── public.tsx
│   │   └── bookmarks.tsx
│   └── users/
│       └── search.tsx
└── types/
    └── index.ts (확장)

routes/
└── web.php (프로필 라우트 추가)

database/
└── migrations/
    └── xxxx_add_profile_settings_to_users_table.php

tests/
├── Feature/
│   ├── PublicProfileTest.php
│   └── UserSearchTest.php
└── Unit/
    ├── ProfileServiceTest.php
    └── UserSearchServiceTest.php
```

## ✅ 완료 기준
- [ ] /@username URL로 공개 프로필 접근 가능
- [ ] 사용자 검색 기능 작동
- [ ] 프로필 통계 정보 정확히 표시
- [ ] 공개 북마크만 다른 사용자에게 표시
- [ ] 프로필 공유 기능 (링크 복사)
- [ ] SEO 친화적 메타 태그 생성
- [ ] 반응형 프로필 페이지
- [ ] 활동 피드 기본 구현

## 🧪 테스트
### Backend 테스트
- [ ] 공개 프로필 접근 권한 테스트
- [ ] 사용자 검색 API 테스트
- [ ] 프로필 통계 계산 테스트
- [ ] SEO 메타 태그 생성 테스트

### Frontend 테스트
- [ ] 프로필 페이지 렌더링 테스트
- [ ] 검색 기능 테스트
- [ ] 공유 기능 테스트
- [ ] 반응형 레이아웃 테스트

### E2E 테스트
- [ ] 사용자 프로필 조회 플로우
- [ ] 사용자 검색 플로우
- [ ] 프로필 공유 플로우

## 📚 참고자료
- [Laravel Route Model Binding](https://laravel.com/docs/11.x/routing#route-model-binding)
- [Open Graph Protocol](https://ogp.me/)
- [Twitter Card Tags](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup)
- [React Share](https://github.com/nygardk/react-share)
- [Next SEO](https://github.com/garmeeh/next-seo) (참고용)

---
**상태**: 📝 계획  
**예상 소요 시간**: 4-5일  
**담당자**: 백엔드/프론트엔드 개발팀  
**우선순위**: 높음  
**의존성**: Phase 1 완료