# 03. 북마크 CRUD 시스템

## 🎯 목표
북마크의 생성, 조회, 수정, 삭제 기능을 구현하여 BookmarkHub의 핵심 기능을 제공합니다.

## 📋 요구사항
### 기능적 요구사항
- 북마크 추가 (URL 입력)
- 북마크 목록 조회 (페이지네이션)
- 북마크 상세 보기
- 북마크 수정 (제목, 설명, 공개 설정)
- 북마크 삭제
- 북마크 검색 기능

### 기술적 요구사항
- URL 유효성 검증
- 메타데이터 기본 추출 (제목)
- 북마크 소유권 검증
- 대용량 데이터 처리 (페이지네이션)

## 🛠️ 구현 사항

### Backend

#### 모델 생성
- [ ] Bookmark 모델 및 마이그레이션 생성
  ```php
  // app/Models/Bookmark.php
  Schema::create('bookmarks', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('url', 2048);
      $table->string('title');
      $table->text('description')->nullable();
      $table->string('thumbnail')->nullable();
      $table->boolean('is_public')->default(true);
      $table->json('metadata')->nullable(); // 나중에 확장용
      $table->timestamp('last_accessed_at')->nullable();
      $table->timestamps();
      
      $table->index(['user_id', 'created_at']);
      $table->index(['is_public', 'created_at']);
      $table->fulltext(['title', 'description']);
  });
  ```

#### 컨트롤러 생성
- [ ] BookmarkController 생성
  ```php
  // app/Http/Controllers/BookmarkController.php
  - index() - 북마크 목록 (페이지네이션)
  - create() - 북마크 생성 폼
  - store() - 북마크 저장
  - show() - 북마크 상세 보기
  - edit() - 북마크 수정 폼
  - update() - 북마크 업데이트
  - destroy() - 북마크 삭제
  - search() - 북마크 검색
  ```

#### 폼 요청 클래스 생성
- [ ] 북마크 검증 클래스
  ```php
  // app/Http/Requests/StoreBookmarkRequest.php
  - URL 형식 검증
  - 제목 길이 제한 (200자)
  - 설명 길이 제한 (1000자)
  - 중복 URL 체크 (선택적)
  
  // app/Http/Requests/UpdateBookmarkRequest.php
  - 기본 필드 검증
  - 소유권 검증 규칙
  ```

#### 서비스 클래스 생성
- [ ] 메타데이터 추출 서비스
  ```php
  // app/Services/MetadataService.php
  - extractMetadata($url) - URL에서 기본 정보 추출
  - validateUrl($url) - URL 접근 가능성 확인
  - extractTitle($html) - HTML에서 제목 추출
  ```

#### 정책 클래스 생성
- [ ] BookmarkPolicy 생성
  ```php
  // app/Policies/BookmarkPolicy.php
  - view() - 북마크 조회 권한
  - create() - 북마크 생성 권한
  - update() - 북마크 수정 권한
  - delete() - 북마크 삭제 권한
  ```

### Frontend

#### 타입 정의
- [ ] 북마크 관련 타입 정의
  ```typescript
  // resources/js/types/index.ts
  interface Bookmark {
    id: number;
    user_id: number;
    url: string;
    title: string;
    description?: string;
    thumbnail?: string;
    is_public: boolean;
    last_accessed_at?: string;
    created_at: string;
    updated_at: string;
    user?: User;
  }
  
  interface BookmarkForm {
    url: string;
    title: string;
    description?: string;
    is_public: boolean;
  }
  ```

#### 페이지 컴포넌트 생성
- [ ] 북마크 목록 페이지
  ```tsx
  // resources/js/pages/bookmarks/index.tsx
  - 북마크 카드 목록
  - 검색 기능
  - 페이지네이션
  - 필터링 (공개/비공개)
  ```

- [ ] 북마크 생성 페이지
  ```tsx
  // resources/js/pages/bookmarks/create.tsx
  - URL 입력 폼
  - 메타데이터 미리보기
  - 공개 설정 토글
  ```

- [ ] 북마크 상세 페이지
  ```tsx
  // resources/js/pages/bookmarks/show.tsx
  - 북마크 정보 표시
  - 외부 링크 연결
  - 편집/삭제 버튼
  ```

- [ ] 북마크 수정 페이지
  ```tsx
  // resources/js/pages/bookmarks/edit.tsx
  - 기존 정보 수정 폼
  - URL 변경 시 메타데이터 재추출
  ```

#### UI 컴포넌트 생성
- [ ] BookmarkCard 컴포넌트
  ```tsx
  // resources/js/components/BookmarkCard.tsx
  - 북마크 썸네일
  - 제목과 설명
  - 액션 버튼 (편집, 삭제)
  - 공개 상태 표시
  ```

- [ ] BookmarkForm 컴포넌트
  ```tsx
  // resources/js/components/BookmarkForm.tsx
  - 재사용 가능한 폼 컴포넌트
  - 실시간 유효성 검증
  - URL 메타데이터 추출
  ```

## 📁 파일 구조
```
app/
├── Http/
│   ├── Controllers/
│   │   └── BookmarkController.php
│   └── Requests/
│       ├── StoreBookmarkRequest.php
│       └── UpdateBookmarkRequest.php
├── Models/
│   └── Bookmark.php
├── Policies/
│   └── BookmarkPolicy.php
└── Services/
    └── MetadataService.php

database/
└── migrations/
    └── xxxx_create_bookmarks_table.php

resources/js/
├── components/
│   ├── BookmarkCard.tsx
│   ├── BookmarkForm.tsx
│   └── ui/ (기존)
├── pages/
│   └── bookmarks/
│       ├── index.tsx
│       ├── create.tsx
│       ├── show.tsx
│       └── edit.tsx
└── types/
    └── index.ts (수정)

routes/
├── web.php (북마크 라우트 추가)
└── auth.php (기존)

tests/
├── Feature/
│   └── BookmarkTest.php
└── Unit/
    ├── BookmarkModelTest.php
    └── MetadataServiceTest.php
```

## ✅ 완료 기준
- [ ] 북마크 생성 기능 (URL 입력 시 제목 자동 추출)
- [ ] 북마크 목록 표시 (페이지네이션 포함)
- [ ] 북마크 상세 보기 페이지
- [ ] 북마크 수정/삭제 기능
- [ ] 북마크 검색 기능 (제목, 설명)
- [ ] 공개/비공개 설정 기능
- [ ] 소유권 기반 접근 제어
- [ ] 반응형 UI 구현
- [ ] 모든 기능에 대한 유효성 검증

## 🧪 테스트
### Backend 테스트
- [ ] 북마크 CRUD 기능 테스트
- [ ] 메타데이터 추출 테스트
- [ ] 권한 검증 테스트
- [ ] 유효성 검증 테스트
- [ ] 페이지네이션 테스트

### Frontend 테스트
- [ ] 북마크 폼 제출 테스트
- [ ] 목록 페이지 렌더링 테스트
- [ ] 검색 기능 테스트
- [ ] 카드 컴포넌트 테스트

### E2E 테스트
- [ ] 북마크 생성 전체 플로우
- [ ] 북마크 수정 전체 플로우
- [ ] 북마크 삭제 전체 플로우
- [ ] 검색 및 필터링 플로우

## 📚 참고자료
- [Laravel Eloquent Relationships](https://laravel.com/docs/11.x/eloquent-relationships)
- [Laravel Full Text Search](https://laravel.com/docs/11.x/database#full-text-where-clauses)
- [Laravel Authorization](https://laravel.com/docs/11.x/authorization)
- [Guzzle HTTP Client](https://docs.guzzlephp.org/en/stable/)
- [Open Graph Protocol](https://ogp.me/)

---
**상태**: 📝 계획  
**예상 소요 시간**: 5-7일  
**담당자**: 백엔드/프론트엔드 개발팀  
**우선순위**: 매우 높음  
**의존성**: 02-user-auth.md